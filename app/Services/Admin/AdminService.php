<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminService
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {
    }


    public function register(array $data)
    {
        $token=null;

        $admin= $this->adminRepository->register($data);
        if (!$admin)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Admin Cannot be created!'));
        }
        $token = $admin->createToken('admin-token', ['actAsAdmin'])->plainTextToken;
        $adminInfo=['email'=>$admin['email'],'token'=>$token];
        return  $this->resourceCreatedResponse($adminInfo,"Admin Register Successful");
    }
    public function login(array $data)
    {
        $admin=$this->adminRepository->login($data);
        if (!$admin)
        {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token=$admin->createToken('patient-token', ['actAsAdmin'])->plainTextToken;
        if (!$token)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Admin Cannot be logged in!'));
        }
        return  $this->resourceCreatedResponse(['token'=>$token],"Admin Login Successful");
    }
    public function edit($id,array $data)
    {
        $admin=$this->adminRepository->edit($id,$data);
        if (!$admin)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Admin Profile Cannot be Edited!'));
        }
        return  $this->resourceCreatedResponse(message: "Admin Profile Edited Successful");

    }
}