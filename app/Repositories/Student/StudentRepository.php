<?php

namespace App\Repositories\Student;

use App\Models\Clinics;
use App\Models\DiagnosisAppointments;
use App\Models\LaboratoryToolsRequired;
use App\Models\Patient;
use App\Models\PatientCases;
use App\Models\PatientDisease;
use App\Models\PatientMedication;
use App\Models\PatientTransferRequests;
use App\Models\Radiographs;
use App\Models\Referrals;
use App\Models\RequiredOperations;
use App\Models\Sections;
use App\Models\Sessions;
use App\Models\Student;
use App\Models\StudentLaboratoryTools;
use App\Models\TypesOfCases;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentRepositoryInterface
{
    use RespondsWithHttpStatus;
    public function register($unNumber,array $data)
    {
            $data['password']=Hash::make($data['password']);
            Student::where('university_number',$unNumber)->first()->update($data);
            return $student=Student::where('university_number',$unNumber)->first();
    }
    public function login(array $data)
    {
        $student=Student::where('email',$data['email'])->first();
        if(!$student || !Hash::check($data['password'],$student->password))
            return null;
        return $student;
    }
    public function edit($id, array $data)
    {
        return $student=Student::where('id',$id)->first()->update($data);
    }

    public function sectionsView()
    {
        return Sections::get();
    }

    public function convertFromSection()
    {

        return Referrals::where('type_of_refarrals','converted_from_section')
            ->with('patientCases.patient','patientCases.typesOfCases.sections')
            ->get();
    }
    public function convertFromStudent()
    {

        return Referrals::where('type_of_refarrals','converted_from_student')
            ->with('patientCases.patient','patientCases.typesOfCases.sections')
            ->get();
    }

    public function studentViewCases($typeId)
    {

        return RequiredOperations::where('types_of_cases_id',$typeId)
            ->with('typesOfCases.sections')
            ->get();
    }

    public function studentSendCases($studentId,$patientCasesId,$note)
    {

        $refferalsNew = Referrals::create([

            'student_id' => $studentId,
            'patient_cases_id' => $patientCasesId,
            'type_of_refarrals' =>'converted_from_student' ,
            'status_of_refarrals' => 'confirmed',
            'status_done' => 'not_finished',
        ]);

        $patientTransferRequest = PatientTransferRequests::create([
            'student_id' => $studentId,
            'referrals_id'=>$refferalsNew->id,
            'note'=>$note,
        ]);

        return [
            $refferalsNew,
            $patientTransferRequest
        ];

    }

    public function studentDiagnosisCases()
    {
        $studentCases = DiagnosisAppointments::where('student_id',auth()->user()->id)
            ->with('patient')
            ->get();

        return [
          $studentCases
        ];

    }
    public function studentPatientHealthRecord($patientId)
    {
        $radiograph = Radiographs::where('patient_id',$patientId)
            ->get();

        $medicine = PatientMedication::where('patient_id',$patientId)
            ->get();

        $diseases = PatientDisease::where('patient_id',$patientId)
            ->with('preexistingDisease')
            ->get();

        return [
            'Radiograph'=>$radiograph,
            'PatientMedication'=>$medicine,
            'PatientDisease'=>$diseases
        ];

    }

    public function studentPatientToolsRequired($patientId,$sessionId)
    {
        $studentTools = LaboratoryToolsRequired::where('patient_id',$patientId)
            ->where('session_id',$sessionId)
            ->where('student_id',auth()->user()->id)
            ->with('patient','sessions')
            ->get();

        return $studentTools;

    }
    public function studentPatientSessions($patientId)
    {
        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patientId)
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;

    }
    public function studentAppointments($history)
    {
//        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
//            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
//            ->where('patient_cases.patient_id', $patientId)
//            ->select('sessions.*')
//            ->with('supervisor','clinics.sections','referrals.patientCases')
//            ->get();

        $data=Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->where('history',$history)
            ->where('referrals.student_id', auth()->user()->id)
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;

    }
    public function studentProfileView()
    {
        return auth()->user();
    }
    public function studentPatientNow()
    {
        $sectionConfirmedFinished = Referrals::where('student_id', auth()->user()->id)
            ->where('type_of_refarrals','converted_from_section')
            ->where('status_of_refarrals','confirmed')
            ->where('status_done','finished')
            ->with('patientCases.patient:id,first_name,last_name,email,gender,birthday,image')
            ->get()
            ->pluck('patientCases.patient')
            ->unique('id');

        $sectionConfirmedNotFinished = Referrals::where('student_id', auth()->user()->id)
            ->where('type_of_refarrals', 'converted_from_section')
            ->where('status_of_refarrals', 'confirmed')
            ->where('status_done', 'not_finished')
            ->with('patientCases.patient:id,first_name,last_name,email,gender,birthday,image')
            ->get()
            ->pluck('patientCases.patient')
            ->unique('id');

        $studentConfirmedFinished = Referrals::where('student_id', auth()->user()->id)
            ->where('type_of_refarrals', 'converted_from_student')
            ->where('status_of_refarrals', 'confirmed')
            ->where('status_done', 'finished')
            ->with('patientCases.patient:id,first_name,last_name,email,gender,birthday,image')
            ->get()
            ->pluck('patientCases.patient')
            ->unique('id');

        $studentConfirmedNotFinished = Referrals::where('student_id', auth()->user()->id)
            ->where('type_of_refarrals', 'converted_from_student')
            ->where('status_of_refarrals', 'confirmed')
            ->where('status_done', 'not_finished')
            ->with('patientCases.patient:id,first_name,last_name,email,gender,birthday,image')
            ->get()
            ->pluck('patientCases.patient')
            ->unique('id');

        $allPatients = $sectionConfirmedFinished
            ->merge($sectionConfirmedNotFinished)
            ->merge($studentConfirmedFinished)
            ->merge($studentConfirmedNotFinished)
            ->unique('id');

        return [
            $allPatients
        ];
    }
    public function addTools($details_of_tool,$image_tool)
    {
        $tools= StudentLaboratoryTools::create([
            'student_id' => auth()->user()->id,
            'details_of_tool'=>$details_of_tool,
            'image_tool'=>$image_tool
        ]);
        return [
            'id'=>$tools['id'],
            'details_of_tool'=>$tools['details_of_tool'],
            'image_tool'=>$tools['image_tool'],
        ];
    }
    public function getTools()
    {
        return StudentLaboratoryTools::where('student_id',auth()->id())->get();
    }
    public function destroyTools($id)
    {
        return StudentLaboratoryTools::where('id',$id)->delete();
    }

    public function getClinicsBySectionId($id)
    {
        return Clinics::where('section_id',$id)->get();
    }
    public function addSession($data)
    {
        $session=Sessions::create([
           'clinic_id'=>$data['clinic_id'],
           'referrals_id'=>$data['referrals_id'],
           'history'=>$data['history'],
           'timeSession'=>$data['timeSession'],
           'status_of_session'=> 'not_complete',
        ]);

        return $session;
    }
    public function updateSession($data)
    {
        $session=Sessions::find($data['session_id'])
            ->update([
                'status_of_session'=> $data['status_of_session'],
                'student_notes'=> $data['student_notes'],
        ]);

        return $session;
    }
    public function tupeOfSections()
    {
        $sections=TypesOfCases::with('sections')->get();

        return $sections;
    }



}
