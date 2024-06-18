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

    public function getClinic()
    {

        $supervisor=$this->supervisorRepository->getClinic();
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('NotFound Clinics'));
        }
        return  $this->successResponse(data:$supervisor,message:"Supervisor");
    }
    public function getSessionsNotAssignment($clinic_id)
    {

        $supervisor=$this->supervisorRepository->getSessionsNotAssignment($clinic_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Sessions'));
        }
        return  $this->successResponse(data:$supervisor,message:" the Sessions was not Assign to Supervisors");
    }

    public function sessionDetails($session_id)
    {

        $supervisor=$this->supervisorRepository->sessionDetails($session_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('NotFound Sessions'));
        }
        return  $this->successResponse(data:$supervisor,message:"Session Details");
    }
    public function addSessionNotes($session_id,$notes,$evaluation)
    {

        $supervisor=$this->supervisorRepository->addSessionNotes($session_id,$notes,$evaluation);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('not found session'));
        }
        return  $this->successResponse(data:$supervisor,message:"Notes Added Success");
    }
    public function studentInClinics()
    {

        $supervisor=$this->supervisorRepository->studentInClinics();
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('not found Students'));
        }
        return  $this->successResponse(data:$supervisor,message:"Clinics Student");
    }
    public function studentPatient($clinic_id)
    {

        $supervisor=$this->supervisorRepository->studentPatient($clinic_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Student not Found'));
        }
        return  $this->successResponse(data:$supervisor,message:"Student Patients");
    }
    public function patientRelatedWithSessions($patient_id)
    {

        $supervisor=$this->supervisorRepository->patientRelatedWithSessions($patient_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Patient not Found'));
        }
        return  $this->successResponse(data:$supervisor,message:"Patient Related Sessions ");
    }
    public function getMySessions($clinic_id)
    {
        $supervisor=$this->supervisorRepository->getMySessions($clinic_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Sessions'));
        }
        return  $this->successResponse(data:$supervisor,message:" My Sessions was Supervisor them");
    }

    public  function getMySections($id)
    {
        $supervisor=$this->supervisorRepository->getMySections($id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Sections'));
        }
        return  $this->successResponse(data:$supervisor,message:" My Sections was Supervisor them");
    }
    public  function getClinicsBySectionId($section_id)
    {
        $supervisor=$this->supervisorRepository->getClinicsBySectionId($section_id);
        if (!$supervisor)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Clinics'));
        }
        return  $this->successResponse(data:$supervisor,message:" The Clinics Related by Section");
    }
    public  function getSessionToday(array $data)
    {
        $session=$this->supervisorRepository->getSessionToday($data);
        if (!$session)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Session'));
        }

        return  $this->successResponse(data:$session,message:" The Session Related by Clinic ID");
    }
    public  function getPatientToday(array $data)
    {
        $patient=$this->supervisorRepository->getPatientToday($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Patient'));
        }

        return  $this->successResponse(data:$patient,message:" The Patient");
    }
    public function getStudentsRelatedPatient(array $data)
    {
        $patient=$this->supervisorRepository->getStudentsRelatedPatient($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Students'));
        }

        return  $this->successResponse(data:$patient,message:" The Students Related of the Patient");
    }
    public function getSessionsRelatedPatientStudent(array $data)
    {
        $patient=$this->supervisorRepository->getSessionsRelatedPatientStudent($data);
        if (!$patient)
        {
            throw new HttpResponseException($this->notFoundResponse('Not Found Sessions'));
        }

        return  $this->successResponse(data:$patient,message:" The Sessions Related Between Patient and Student");
    }

}

