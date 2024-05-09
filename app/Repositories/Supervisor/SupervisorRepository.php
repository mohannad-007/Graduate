<?php

namespace App\Repositories\Supervisor;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Supervisor;
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
}
