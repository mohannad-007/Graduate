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
    public function currentPatientView()
    {
        $patient = $this->diagnosisRepository->currentPatientView();
        if (!$patient) {
            throw new HttpResponseException($this->internalErrorResponse('You dont have an Appointment today!'));
        }
        return $this->resourceFoundResponse(data: $patient,message:"Diagnosis Appointment ");
    }
    public function acceptPatientAppointment(array $data)
    {
        $appointment = $this->diagnosisRepository->acceptPatientAppointment($data);
        if (!$appointment) {
            throw new HttpResponseException($this->internalErrorResponse('Appointment notFound!'));
        }
        return $this->resourceFoundResponse(data: $appointment,message:"Diagnosis Appointment Accepted");
    }
    public function studentView()
    {
        $student = $this->diagnosisRepository->studentView();
        if (!$student) {
            throw new HttpResponseException($this->internalErrorResponse('Student notFound!'));
        }
        return $this->resourceFoundResponse(data: $student,message:"All Student");
    }
    public function studentTrueDiagnosisView()
    {
        $student = $this->diagnosisRepository->studentTrueDiagnosisView();
        if (!$student) {
            throw new HttpResponseException($this->internalErrorResponse('Student notFound!'));
        }
        return $this->resourceFoundResponse(data: $student,message:"All Student Have Access To Diagnosis");
    }
    public function studentGiveRules($studentIds)
    {
        $student = $this->diagnosisRepository->studentGiveRules($studentIds);
        if (!$student) {
            throw new HttpResponseException($this->internalErrorResponse('Student notFound!'));
        }
        return $this->resourceFoundResponse(data: $student,message:"Students Give Diagnosis Access");
    }




}
