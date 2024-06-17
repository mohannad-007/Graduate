<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisAppointments;
use App\Models\PatientCases;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentConvertToSectionController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }
    //التحويل الى القسم

    public function addPatientCases(Request $request)
    {

        $patientId=DiagnosisAppointments::find($request['diagnosis_appointments_id']);
        $cases = $request->cases;
        foreach ($cases as $index => $casesData) {
            $types_of_cases_id = 'cases.' . $index . '.types_of_cases_id';
            $details_of_cases = 'cases.' . $index . '.details_of_cases';
            $casesData['student_id'] = auth()->id();
            $casesData['patient_id'] = $patientId->patient_id;
            $casesData['diagnosis_appointments_id'] =$request['diagnosis_appointments_id'];
            $casesData['types_of_cases_id'] = $request->$types_of_cases_id;
            $casesData['details_of_cases'] = $request->$details_of_cases;

            PatientCases::create($casesData);
        }
        DiagnosisAppointments::where('id',$request['diagnosis_appointments_id'])->update(['order_status'=>'done_diagnosis']);
        return $this->successResponse('تم التحويل بنجاح', 200);
    }

    public function tupeOfSections(){

        return $this->userService->tupeOfSections();
    }
}
