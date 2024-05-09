<?php

namespace App\Services\Supervisor;

use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Supervisor\SupervisorRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class SupervisorService
{
    use RespondsWithHttpStatus;

    public function __construct(
        protected SupervisorRepositoryInterface $supervisorRepository
    )
    {
    }

    public function register(array $data)
    {
        $token = null;
        $supervisor = $this->supervisorRepository->register($data);
        if (!$supervisor) {
            throw new HttpResponseException($this->internalErrorResponse('The Supervisor Cannot be created!'));
        }
        $token = $supervisor->createToken('supervisor-token', ['actAsSupervisor'])->plainTextToken;
        $adminInfo = ['email' => $supervisor['email'], 'token' => $token];
        return $this->resourceCreatedResponse($adminInfo, "Supervisor Register Successful");
    }

    public function delete($id)
    {
        $supervisor = $this->supervisorRepository->delete($id);
        if (!$supervisor) {
            throw new HttpResponseException($this->internalErrorResponse('The Supervisor Cannot be deleted!'));
        }
        return $this->resourceDeletedResponse("Supervisor Deleted Successful");
    }
    public function edit($id,array $data)
    {
        $supervisor=$this->supervisorRepository->edit($id,$data);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Supervisor Profile Cannot be Edited!'));
        }
        return  $this->resourceCreatedResponse(message: "Supervisor Profile Edited Successful");

    }
    public function login(array $data)
    {

        $supervisor=$this->supervisorRepository->login($data);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token=$supervisor->createToken('supervisor-token', ['actAsSupervisor'])->plainTextToken;
        if (!$token)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Supervisor Cannot be logged in!'));
        }
        return  $this->resourceCreatedResponse(['token'=>$token],"Supervisor Login Successful");
    }
}
