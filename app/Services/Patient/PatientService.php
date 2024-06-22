<?php

namespace App\Services\Patient;

use App\Models\PatientHealthRecords;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class PatientService
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected PatientRepositoryInterface $patientRepository
    ) {
    }
    public function register(array $data)
    {
        $token=null;
        $patient= $this->patientRepository->register($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Patient Cannot be created!'));
        }
        $token = $patient->createToken('patient-token', ['actAsPatient'])->plainTextToken;
        $patientInfo=['email'=>$patient['email'],'token'=>$token];
      return  $this->resourceCreatedResponse($patientInfo,"Patient Register Successful");
    }
    public function login(array $data)
    {

        $patient=$this->patientRepository->login($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token=$patient->createToken('patient-token', ['actAsPatient'])->plainTextToken;
        if (!$token)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Patient Cannot be logged in!'));
        }
        return  $this->resourceCreatedResponse(['token'=>$token],"Patient Login Successful");
    }

    public function create($id,array $data)
    {
        $patient=$this->patientRepository->create($id,$data);
        if (!$patient)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Patient Profile Cannot be Created!'));
        }
        return  $this->resourceUpdatedResponse(data: $data ,message: "Patient Profile Created Successful");
    }

    public function showProfileInfo()
    {
        $patient= $this->patientRepository->showProfileInfo();
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('The Patient Profile Cannot be Found!'));
        }
        return $this->resourceCreatedResponse(data: $patient,message: "Patient Profile Found Successful");
    }

    public function showPatientCaseByPatientId($patient_id){

        $patient=$this->patientRepository->showPatientCaseByPatientId($patient_id);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('The Patient Case Cannot be Found!'));
        }
        return $this->resourceFoundResponse(data: $patient,message: "Patient Case Found Successful");
    }

    public function patientSessionRelatedWithStudent($patient_id,$student_id){

        $patient=$this->patientRepository->patientSessionRelatedWithStudent($patient_id,$student_id);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('The Patient Session Cannot be Found!'));
        }

        return $this->resourceFoundResponse(data: $patient,message: "Patient Session Found Successful");
    }

    public function bookAppointment($data){

        $patient=$this->patientRepository->bookAppointment($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->forbiddenResponse('The Patient request have problem!'));
        }
        return $this->successResponse(data: $patient,message: "Patient book request Successful");
    }

//    public function viseted($patient_id){
//
//        $patient=$this->patientRepository->viseted($patient_id);
//        if (!$patient)
//        {
//            throw new HttpResponseException($this->notFoundResponse('User not Found!'));
//        }
//        return $this->successResponse(data: $patient,message: "Patient Viseted");
//    }
//    public function archiveVisited($patient_id){
//
//        $patient=$this->patientRepository->archiveVisited($patient_id);
//        if (!$patient)
//        {
//            throw new HttpResponseException($this->notFoundResponse('User not Found!'));
//        }
//        return $this->successResponse(data: $patient,message: "Patient Archive Visited");
//    }

    public function myAppointment($patient_id){

        $patient=$this->patientRepository->myAppointment($patient_id);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('User not Found!'));
        }
        return $this->successResponse(data: $patient,message: "Patient Appointment");
    }

    public function archiveMyAppointment($patient_id){

        $patient=$this->patientRepository->archiveMyAppointment($patient_id);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('User not Found!'));
        }
        return $this->successResponse(data: $patient,message: "Patient Archive Appointment");
    }

    public function toolsRequireds($patient_id){

        $patient=$this->patientRepository->toolsRequireds($patient_id);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('User not Found!'));
        }
        return $this->successResponse(data: $patient,message: "Patient Tools Required");
    }

    public function viewDiseases(){

        $patient=$this->patientRepository->viewDiseases();
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('Diseases not Found!'));
        }
        return $this->successResponse(data: $patient,message: "Patient Diseases");
    }
    public function viewHealthRecord(){

    $patient=$this->patientRepository->viewHealthRecord();
    if (!$patient)
    {
        throw new HttpResponseException($this->notFoundResponse('Health Record not Found!'));
    }
    return $this->successResponse(data: $patient,message: "Patient Health Record");
    }

    public function patientRelatedWithStudent($patientId){

    $patient=$this->patientRepository->patientRelatedWithStudent($patientId);
    if (!$patient)
    {
        throw new HttpResponseException($this->notFoundResponse('patient not Found!'));
    }
    return $this->successResponse(data: $patient,message: "Patient Related With Student");
    }



}
