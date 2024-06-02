<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisAppointments;
use App\Models\Student;
use App\Traits\RespondsWithHttpStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class PatientSortingViaStudentsController extends Controller
{

    use RespondsWithHttpStatus;


    public function patientSortingViaStudents()
    {

        $appointments = DiagnosisAppointments::where([
            ['date', Carbon::today()->toDateString()],
            ['order_status', 'acceptable']
        ])->get();

        $students = Student::where('diagnosis', true)->get();

        $numPatients = $appointments->count();
        $numStudents = $students->count();

//        dd($numStudents);

        if ($numStudents == 0) {
            return response()->json(['error' => 'No students with diagnosis permission available'], 400);
        }

        $updatedAppointments = [];

        // الحالة 1: المرضى أكثر من الطلاب
        if ($numPatients > $numStudents) {
            $patientsPerStudent = intdiv($numPatients, $numStudents);
            $extraPatients = $numPatients % $numStudents;

            foreach ($students as $student) {
                $assignedPatients = $appointments->splice(0, $patientsPerStudent);
                foreach ($assignedPatients as $appointment) {
                    $appointment->student_id = $student->id;
                    $appointment->save();
                    $updatedAppointments[] = $appointment->load('patient','student'); // إضافة السجل الذي تم تحديثه إلى القائمة
                }
            }

            // توزيع المرضى المتبقين
            foreach ($students as $student) {
                if ($extraPatients > 0) {
                    $appointment = $appointments->shift();
                    if ($appointment) {
                        $appointment->student_id = $student->id;
                        $appointment->save();
                        $updatedAppointments[] = $appointment->load('patient','student'); // إضافة السجل الذي تم تحديثه إلى القائمة
                        $extraPatients--;
                    }
                }
            }
        }
        // الحالة 2: المرضى يساوي عدد الطلاب
        elseif ($numPatients == $numStudents) {
            foreach ($students as $student) {
                $appointment = $appointments->shift();
                if ($appointment) {
                    $appointment->student_id = $student->id;
                    $appointment->save();
                    $updatedAppointments[] = $appointment->load('patient','student'); // إضافة السجل الذي تم تحديثه إلى القائمة
                }
            }
        }
        // الحالة 3: المرضى أقل من الطلاب
        else {
            foreach ($students as $student) {
                $appointment = $appointments->shift();
                if ($appointment) {
                    $appointment->student_id = $student->id;
                    $appointment->save();
                    $updatedAppointments[] = $appointment->load('patient','student'); // إضافة السجل الذي تم تحديثه إلى القائمة
                } else {
                    break; // لا مزيد من المرضى لتوزيعهم
                }
            }
        }

//        return response()->json([
//            'message' => 'Patients Sorted into Student successfully',
//            'updated_appointments' => $updatedAppointments
//        ]);
        return $this->successResponse(data:$updatedAppointments,message:'Patients Sorted into Student successfully' );
    }



}
