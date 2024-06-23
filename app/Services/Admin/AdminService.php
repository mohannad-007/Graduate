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
    public function getPatient()
    {
        $patient=$this->adminRepository->getPatient();
        if ($patient->isEmpty())
        {
            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
        }
        return  $this->resourceFoundResponse(data: $patient,message: 'Patient On The System');
    }
    public function searchPatient($searchTerm)
    {
        $patient=$this->adminRepository->searchPatient($searchTerm);
        if ($patient->isEmpty())
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Patient notFound');
        }
        return  $this->resourceFoundResponse(data: $patient,message: 'Patient You LookFor');
    }
    public function getClinic()
    {
        $clinic=$this->adminRepository->getClinic();
        if ($clinic->isEmpty())
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Clinics notFound');
        }
        return  $this->resourceFoundResponse(data: $clinic,message: 'Clinics');
    }


}
