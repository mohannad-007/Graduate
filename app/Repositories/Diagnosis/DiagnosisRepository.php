<?php

namespace App\Repositories\Diagnosis;

use App\Models\Diagnosis;
use App\Models\DiagnosisAppointments;
use App\Models\Student;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DiagnosisRepository implements  DiagnosisRepositoryInterface
{
    public function register(array $data)
    {
        $data['password']=Hash::make($data['password']);
        $diagnosis=Diagnosis::create($data);
        return $diagnosis;
    }
    public function edit($id, array $data)
    {
        return $diagnosis=Diagnosis::where('id',$id)->first()->update($data);
    }
    public function delete($id)
    {
        return Diagnosis::destroy($id);
    }
    public function login(array $data)
    {
        $diagnosis=Diagnosis::where('email',$data['email'])->first();
        if(!$diagnosis || !Hash::check($data['password'],$diagnosis->password))
            return null;
        return $diagnosis;
    }

    public function pendingPatientView()
    {
        $diagnosis=DiagnosisAppointments::where('order_status','pending')->get();
        return $diagnosis;
    }
    public function acceptPatientView()
    {
        $diagnosis=DiagnosisAppointments::where('order_status','acceptable')->get();
        return $diagnosis;
    }
    public function currentPatientView()
    {
        $diagnosis=DiagnosisAppointments::where('date',Carbon::today())
            ->with('patient','student','diagnosis')
            ->get();
        return $diagnosis;
    }
    public function acceptPatientAppointment($data)
    {
        $diagnosis=DiagnosisAppointments::where('id',$data['id'])
            ->update([
                'order_status'=>'acceptable',
                'date'=>$data['date'],
                'timeDiagnosis'=>$data['timeDiagnosis']
            ]);

        return $diagnosis;
    }
    public function studentView()
    {
        $student=Student::get();

        return $student;
    }
    public function studentTrueDiagnosisView()
    {
        $student=Student::where('diagnosis',1)->get();

        return $student;
    }




}
