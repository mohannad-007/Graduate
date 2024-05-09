<?php

namespace App\Repositories\Section;

use App\Models\Diagnosis;
use App\Models\Sections;
use Illuminate\Support\Facades\Hash;

class SectionRepository implements  SectionRepositoryInterface
{
    public function register(array $data)
    {
        $data['password']=Hash::make($data['password']);
        $section=Sections::create($data);
        return $section;
    }
    public function edit($id, array $data)
    {
        return $section=Sections::where('id',$id)->first()->update($data);
    }
    public function delete($id)
    {
        return Sections::destroy($id);
    }
    public function login(array $data)
    {
        $section=Sections::where('email',$data['email'])->first();
        if(!$section || !Hash::check($data['password'],$section->password))
            return null;
        return $section;
    }
}
