<?php

namespace App\Repositories\Student;

use App\Models\Patient;
use App\Models\Student;
use App\Models\TypesOfCases;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentRepositoryInterface
{
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
        return TypesOfCases::with('sections')->get();
    }

}
