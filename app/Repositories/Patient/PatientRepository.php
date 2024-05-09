<?php

namespace App\Repositories\Patient;

use App\Http\Controllers\Patient\PatientToolsRequiredController;
use App\Models\DiagnosisAppointments;
use App\Models\LaboratoryToolsRequired;
use App\Models\Patient;
use App\Models\PatientCases;
use App\Models\PatientHealthRecords;
use App\Models\Sessions;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Hash;

class PatientRepository implements  PatientRepositoryInterface
{
    use RespondsWithHttpStatus;
    public function register(array $data)
    {

        $patient=Patient::create([
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
        return $patient;
    }

    public function login(array $data)
    {
       $patient=Patient::where('email',$data['email'])->first();
       if(!$patient || !Hash::check($data['password'],$patient->password))
           return null;
       return $patient;
    }

    public function create($id, array $data)
    {
        $patient=Patient::where('id',$id)->first()->update($data);
        return $patient;
    }
    public function showProfileInfo()
    {
        //show profile info from patient table
        return auth()->user();
    }

    public function showPatientCaseByPatientId($patient_id){
        $patient=PatientCases::where('patient_id',$patient_id)
            ->with('patient','student','typesOfCases','diagnosisAppointments')
            ->get();
        return $patient;
    }

    public function patientSession($patient_id,$student_id){

        $sessions = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->where('patient_cases.student_id', $student_id)
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();
        return $sessions;
    }

    public function bookAppointment($data){
        $appointment = DiagnosisAppointments::create([
            'patient_id' => $data['patient_id'],
            'reason' => $data['reason'],
        ]);
        return $appointment;
    }

    public function viseted($patient_id){
        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->where('order_status','done_diagnosis')
            ->get();

        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->where('status_of_session','complete')
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;
    }

    public function myAppointment($patient_id){
        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->where('order_status','acceptable')
            ->get();

        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->where('status_of_session','not_complete')
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;
    }

    public function toolsRequired($patient_id){

        $tools=LaboratoryToolsRequired::where('patient_id',$patient_id)
            ->with('student','sessions')
            ->get();
        return $tools;
    }


}
