<?php

namespace App\Services\Student;

use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentService
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentRepositoryInterface $studentRepository
    ) {
    }
    public function register($unNumber,array $data)
    {
        $token=null;

        $student= $this->studentRepository->register($unNumber,$data);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Student Cannot be created!'));
        }
        $token = $student->createToken('student-token', ['actAsStudent'])->plainTextToken;
        $studentInfo=['email'=>$student['email'],'token'=>$token];
        return  $this->resourceCreatedResponse($studentInfo,"Student Register Successful");
    }
    public function login(array $data)
    {

        $student=$this->studentRepository->login($data);
        if (!$student)
        {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token=$student->createToken('student-token', ['actAsStudent'])->plainTextToken;
        if (!$token)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Student Cannot be logged in!'));
        }
        return  $this->resourceCreatedResponse(['token'=>$token],"Student Login Successful");
    }
    public function edit($id,array $data)
    {
        $student=$this->studentRepository->edit($id,$data);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Student Profile Cannot be Edited!'));
        }
        return  $this->resourceCreatedResponse(data:$data,message: "Student Profile Edited Successful");

    }
    public function sectionsView()
    {
        $student=$this->studentRepository->sectionsView();
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('The Student Cannot be Found!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Sections");
    }

    public function convertFromSection()
    {
        $student=$this->studentRepository->convertFromSection();
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Referrals!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Patient");
    }

    public function convertFromStudent()
    {
        $student=$this->studentRepository->convertFromStudent();
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Referrals!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Patient");
    }
    public function studentViewCases($typeId)
    {
        $student=$this->studentRepository->studentViewCases($typeId);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found type of cases!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Student Cases");
    }
    public function studentSendCases($studentId,$patientCasesId,$note)
    {
        $student=$this->studentRepository->studentSendCases($studentId,$patientCasesId,$note);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found type of cases!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "done send cases");
    }
    public function studentDiagnosisCases()
    {
        $student=$this->studentRepository->studentDiagnosisCases();
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Cases!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "done Get Cases");
    }
    public function studentPatientHealthRecord($patientId)
    {
        $student=$this->studentRepository->studentPatientHealthRecord($patientId);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Health Record!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "done Health Record");
    }
    public function studentPatientToolsRequired($patientId,$sessionId)
    {
        $student=$this->studentRepository->studentPatientToolsRequired($patientId,$sessionId);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Tools!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Patient Tools Required");
    }
    public function studentPatientSessions($patientId)
    {
        $student=$this->studentRepository->studentPatientSessions($patientId);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Session!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Patient Tools Required");
    }
    public function studentAppointments($history)
    {
        $student=$this->studentRepository->studentAppointments($history);
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Session!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "My Appointments");
    }
    public function studentProfileView()
    {
        $student=$this->studentRepository->studentProfileView();
        if (!$student)
        {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Profile!'));
        }
        return  $this->resourceFoundResponse(data: $student,message: "Profile");
    }
    public function studentPatientNow()
    {
        $patient = $this->studentRepository->studentPatientNow();
        if (!$patient) {
            throw new HttpResponseException($this->internalErrorResponse('Not Found Patient!'));
        }
        return $this->resourceFoundResponse(data: $patient, message: "Patients");


    }
}
