<?php

namespace App\Repositories\Diagnosis;

use App\Models\Diagnosis;
use App\Models\DiagnosisAppointments;
use App\Models\Supervisor;
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
}
