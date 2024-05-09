<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
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
        return $admin=Admin::where('id',$id)->first()->update($data);
    }
}
