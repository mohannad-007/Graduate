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
}
