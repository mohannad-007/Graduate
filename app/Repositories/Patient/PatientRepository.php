<?php

namespace App\Repositories\Patient;

use App\Http\Controllers\Patient\PatientToolsRequiredController;
use App\Models\DiagnosisAppointments;
use App\Models\LaboratoryToolsRequired;
use App\Models\Patient;
use App\Models\PatientCases;
use App\Models\PatientDisease;
use App\Models\PatientHealthRecords;
use App\Models\PatientMedication;
use App\Models\PreexistingDisease;
use App\Models\Radiographs;
use App\Models\Sessions;
use App\Traits\RespondsWithHttpStatus;
use Carbon\Carbon;
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

    public function patientSessionRelatedWithStudent($patient_id,$student_id){

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

        DiagnosisAppointments::where('date','<',Carbon::now()->startOfDay())
            ->where('order_status','done_diagnosis')
            ->delete();
        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->where('order_status','done_diagnosis')
            ->get();


        Sessions::where('history','<',Carbon::now()->startOfDay())
            ->where(function ($query) {
                $query->where('status_of_session', 'complete')
                    ->orWhere('status_of_session', 'last_refarral');
                })
            ->delete();
        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->where(function ($query) {
                $query->where('status_of_session', 'complete')
                    ->orWhere('status_of_session', 'last_refarral');
                })
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;
    }
    public function archiveVisited($patient_id){

        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->onlyTrashed()
            ->get();

        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->onlyTrashed()
            ->get();

        return $data;
    }

    public function myAppointment($patient_id){

        DiagnosisAppointments::where('date','<',Carbon::now()->startOfDay())
            ->where('order_status','done_diagnosis')
            ->delete();
        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->where('order_status','acceptable')
            ->get();


        Sessions::where('history','<',Carbon::now()->startOfDay())
            ->where(function ($query) {
                $query->where('status_of_session', 'complete')
                    ->orWhere('status_of_session', 'last_refarral');
                })
            ->delete();
        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->where('status_of_session','not_complete')
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->get();

        return $data;
    }

    public function archiveMyAppointment($patient_id){

        $data['diagnosisAppointments'] = DiagnosisAppointments::where('patient_id', $patient_id)
            ->onlyTrashed()
            ->get();

        $data['sessions'] = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->select('sessions.*')
            ->with('supervisor','clinics.sections','referrals.patientCases')
            ->onlyTrashed()
            ->get();

        return $data;
    }

    public function toolsRequired($patient_id){

        $tools=LaboratoryToolsRequired::join('sessions','laboratory_tools_requireds.session_id','=','sessions.id')
            ->where('sessions.history','>=',Carbon::now()->startOfDay())
            ->where('patient_id',$patient_id)
            ->select('laboratory_tools_requireds.*')
            ->with('student','sessions')
            ->get();

        return $tools;
    }

    public function viewDiseases(){

        $Diseases=PreexistingDisease::get();
        return $Diseases;
    }
    public function viewHealthRecord(){

        $healthRecord=PatientHealthRecords::where('patient_id',auth()->user()->id)
            ->first();
        if ($healthRecord==null){
            return false;
        }
        $radiograph=Radiographs::where('patient_id',auth()->user()->id)->get();
        $medicine=PatientMedication::where('patient_id',auth()->user()->id)->get();
        $disease=PatientDisease::where('patient_id',auth()->user()->id)->with('preexistingDisease')->get();
        return [
            'Patient Radiographs'=>$radiograph,
            'Patient Medicine'=>$medicine,
            'Patient Disease'=>$disease,
        ];
    }
    public function patientRelatedWithStudent($patientId){

        $student=Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patientId)
            ->select('sessions.*')
            ->with('referrals.student')
            ->get();

        $student2=DiagnosisAppointments::where('patient_id', $patientId)
            ->with('student')
            ->get();

        return [
            'Patient related with student'=>$student,
            'Patient related with student2'=>$student2,
        ];
    }




}
