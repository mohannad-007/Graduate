<?php

namespace App\Repositories\Supervisor;

use App\Models\Admin;
use App\Models\Sessions;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\SupervisorTime;
use Illuminate\Support\Facades\Hash;

class SupervisorRepository implements  SupervisorRepositoryInterface
{
    public function register(array $data)
    {
        $data['password']=Hash::make($data['password']);
        //dd($data);
        $supervisor=Supervisor::create($data);
        return $supervisor;
    }
    public function delete($id)
    {
        return Supervisor::destroy($id);
    }
    public function edit($id, array $data)
    {
        return $supervisor=Supervisor::where('id',$id)->first()->update($data);
    }
    public function login(array $data)
    {
        $supervisor=Supervisor::where('email',$data['email'])->first();
     //   dd($supervisor);
        if(!$supervisor || !Hash::check($data['password'],$supervisor->password))
            return null;
        return $supervisor;
    }
    public function getClinic()
    {
        $supervisor=SupervisorTime::where('supervisor_id',auth()->user()->id)
            ->with('supervisor','clinics')
            ->get();
        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function sessionDetails($session_id)
    {
        $supervisor=Sessions::where('id',$session_id)
            ->with('supervisor','clinics','referrals')
            ->get();
        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function addSessionNotes($session_id,$notes,$evaluation)
    {
        $supervisor=Sessions::where([
            'id'=>$session_id
        ])
            ->update(['supervisor_notes'=>$notes,'supervisor_evaluation'=>$evaluation,'supervisor_id'=>auth()->user()->id]);
        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function getSessionsNotAssignment($clinic_id)
    {
        $supervisor=Sessions::where('clinic_id',$clinic_id)
            ->where('supervisor_id',null)
            ->with('clinics','referrals')
            ->get();
        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function studentInClinics()
    {
        $supervisor = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('student', 'referrals.student_id', '=', 'student.id')
            ->select('sessions.clinic_id', 'student.*')
            ->orderBy('sessions.clinic_id')
            ->get()
            ->groupBy('clinic_id');
        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function studentPatient($clinic_id)
    {
        $supervisor=Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->join('patient', 'patient_cases.patient_id', '=', 'patient.id')
            ->where('sessions.clinic_id', $clinic_id)
            ->select(
                'patient.*',
                'patient_cases.*',
                'referrals.*',
                'sessions.*'
            )
            ->orderBy('referrals.student_id')
            ->get()
            ->groupBy('referrals.student_id');

        if(!$supervisor)
            return null;
        return $supervisor;
    }
    public function patientRelatedWithSessions($patient_id)
    {
        $patient=Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->where('patient_cases.patient_id', $patient_id)
            ->select('sessions.*')
            ->with('referrals.patientCases.patient')
            ->get();

        if(!$patient)
            return null;
        return $patient;
    }
    public function getMySessions($clinic_id)
    {
        $supervisor=Sessions::where([
            'clinic_id'=>$clinic_id,
            'supervisor_id'=>auth()->user()->id
        ])
            ->with('clinics','referrals')
            ->get();
        if(!$supervisor)
            return null;
        return $supervisor;
    }




}
