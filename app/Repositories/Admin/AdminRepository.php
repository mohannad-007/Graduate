<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Models\Clinics;
use App\Models\Patient;
use App\Models\Sections;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{

    public function register(array $data)
    {
        $admin=Admin::create([
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
        return $admin;
    }
    public function login(array $data)
    {
        $admin=Admin::where('email',$data['email'])->first();
        if(!$admin || !Hash::check($data['password'],$admin->password))
            return null;
        return $admin;
    }
    public function edit($id, array $data)
    {
        return Admin::where('id',$id)->first()->update($data);
    }
    public function getPatient()
    {
        return Patient::get();
    }
    public function searchPatient($searchTerm)
    {
        return Patient::where('first_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
            ->get();
    }
    public function getClinic()
    {
        return Clinics::with('sections')->get();
    }
    public function getSpecificClinic($clinicID)
    {
        return Clinics::where('id',$clinicID)->with('sections')->get();
    }
    public function deleteSpecificClinic($clinicID)
    {
        return Clinics::where('id',$clinicID)->delete();
    }
    public function updateSpecificClinic($clinicID,$number)
    {
        return Clinics::where('id',$clinicID)->update([
            'number'=>$number
        ]);
    }
    public function createClinic($sectionID,$number)
    {
        return Clinics::create([
            'section_id'=>$sectionID,
            'number'=>$number
        ]);
    }
    public function createStudentInfo($UN)
    {
        return Student::create([
            'university_number'=>$UN
        ]);
    }
    public function updateStudentInfo($UN,$id)
    {
        return Student::find($id)->update([
            'university_number'=>$UN
        ]);
    }
    public function viewAllStudentInfo()
    {
        return Student::get();
    }
    public function viewSpecificStudentInfo($id)
    {
        return Student::where('id',$id)->get();
    }
    public function deleteSpecificStudentInfo($id)
    {
        return Student::where('id',$id)->delete();
    }
    public function giveRuleDiagnosisToStudent($id)
    {
        return Student::where('id',$id)->update([
            'diagnosis'=>1
        ]);
    }
    public function getAllSections()
    {
        return Sections::get();
    }
    public function deleteSpecificSections($id)
    {
        return Sections::where('id',$id)->delete();
    }
}
