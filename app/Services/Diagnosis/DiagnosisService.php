<?php

namespace App\Services\Diagnosis;

use App\Repositories\Diagnosis\DiagnosisRepositoryInterface;
use App\Repositories\Supervisor\SupervisorRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiagnosisService
{

    use RespondsWithHttpStatus;

    public function __construct(
        protected DiagnosisRepositoryInterface $diagnosisRepository
    )
    {
    }

    public function register(array $data)
    {
        $token = null;
        $diagnosis = $this->diagnosisRepository->register($data);
        if (!$diagnosis) {
            throw new HttpResponseException($this->internalErrorResponse('The Diagnosis Cannot be created!'));
        }
        $token = $diagnosis->createToken('diagnosis-token', ['actAsDiagnosis'])->plainTextToken;
        $diagnosisInfo = ['email' => $diagnosis['email'], 'token' => $token];
        return $this->resourceCreatedResponse($diagnosisInfo, "Diagnosis Register Successful");
    }
    public function edit($id,array $data)
    {
        $diagnosis=$this->diagnosisRepository->edit($id,$data);
        if (!$diagnosis)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Diagnosis Profile Cannot be Edited!'));
        }
        return  $this->resourceCreatedResponse(message: "Diagnosis Profile Edited Successful");

    }
    public function delete($id)
    {
        $diagnosis = $this->diagnosisRepository->delete($id);
        if (!$diagnosis) {
            throw new HttpResponseException($this->internalErrorResponse('The Diagnosis Cannot be deleted!'));
        }
        return $this->resourceDeletedResponse("Diagnosis Deleted Successful");
    }
    public function login(array $data)
    {

        $diagnosis=$this->diagnosisRepository->login($data);
        if (!$diagnosis)
        {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token=$diagnosis->createToken('diagnosis-token', ['actAsDiagnosis'])->plainTextToken;
        if (!$token)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Diagnosis Cannot be logged in!'));
        }
        return  $this->resourceCreatedResponse(['token'=>$token],"Diagnosis Login Successful");
    }
    public function pendingPatientView()
    {
        $patient = $this->diagnosisRepository->pendingPatientView();
        if (!$patient) {
            throw new HttpResponseException($this->internalErrorResponse('You dont have an Appointment!'));
        }
        return $this->resourceFoundResponse(data: $patient,message:"Diagnosis Found Successful");
    }
    public function acceptPatientView()
    {
        $patient = $this->diagnosisRepository->acceptPatientView();
        if (!$patient) {
            throw new HttpResponseException($this->internalErrorResponse('You dont have an Accepted Appointment!'));
        }
        return $this->resourceFoundResponse(data: $patient,message:"Diagnosis Found Successful");
    }




}
