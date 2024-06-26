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
    public function getSpecificClinic($clinicID)
    {
        $clinic=$this->adminRepository->getSpecificClinic($clinicID);
        if ($clinic->isEmpty())
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Clinic notFound');
        }
        return  $this->resourceFoundResponse(data: $clinic,message: 'Clinic Info');
    }
    public function deleteSpecificClinic($clinicID)
    {
        $clinic=$this->adminRepository->deleteSpecificClinic($clinicID);
        if (!$clinic)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Clinic notFound');
        }
        return  $this->resourceDeletedResponse(message:'Clinic Deleted Successful');
    }
    public function updateSpecificClinic($clinicID,$number)
    {
        $clinic=$this->adminRepository->updateSpecificClinic($clinicID,$number);
        if (!$clinic)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Clinic notFound');
        }
        return  $this->resourceUpdatedResponse(data:$clinic,message: 'Clinic Updated Successful');
    }
    public function createClinic($sectionID,$number)
    {
        $clinic=$this->adminRepository->createClinic($sectionID,$number);
        if (!$clinic)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Clinic not created');
        }
        return  $this->resourceCreatedResponse(data:$clinic,message: 'Clinic created Successful');
    }
    public function createStudentInfo($UN)
    {
        $student=$this->adminRepository->createStudentInfo($UN);
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Student NotFound');
        }
        return  $this->resourceCreatedResponse(data:$student,message: 'Student created Successful');
    }
    public function updateStudentInfo($UN,$id)
    {
        $student=$this->adminRepository->updateStudentInfo($UN,$id);
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Student NotFound');
        }
        return  $this->resourceUpdatedResponse(data:$student,message: 'Student updated Successful');
    }
    public function viewAllStudentInfo()
    {
        $student=$this->adminRepository->viewAllStudentInfo();
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message:'Student NotFound');
        }
        return  $this->resourceFoundResponse(data:$student,message:'Student');
    }
    public function viewSpecificStudentInfo($id)
    {
        $student=$this->adminRepository->viewSpecificStudentInfo($id);
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message:'Student NotFound');
        }
        return  $this->resourceFoundResponse(data:$student,message:'Student');
    }
    public function deleteSpecificStudentInfo($id)
    {
        $student=$this->adminRepository->deleteSpecificStudentInfo($id);
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Student NotFound');
        }
        return  $this->resourceDeletedResponse(message:'Student Deleted Successful');
    }
    public function giveRuleDiagnosisToStudent($id)
    {
        $student=$this->adminRepository->giveRuleDiagnosisToStudent($id);
        if (!$student)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Student NotFound');
        }
        return  $this->resourceUpdatedResponse(message:'Student Successful Give Rules');
    }
    public function getAllSections()
    {
        $section=$this->adminRepository->getAllSections();
        if (!$section)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Sections NotFound');
        }
        return  $this->resourceFoundResponse(data:$section,message:'Sections');
    }
    public function deleteSpecificSections($id)
    {
        $section=$this->adminRepository->deleteSpecificSections($id);
        if (!$section)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Sections NotFound');
        }
        return  $this->resourceDeletedResponse(message:'Sections Deleted Successful');
    }
    public function getProfileSections()
    {
        $section=$this->adminRepository->getProfileSections();
        if (!$section)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Sections NotFound');
        }
        return  $this->resourceFoundResponse(data:$section,message:'Sections');
    }
    public function getProfileSupervisor()
    {
        $supervisor=$this->adminRepository->getProfileSupervisor();
        if (!$supervisor)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Supervisor NotFound');
        }
        return  $this->resourceFoundResponse(data:$supervisor,message:'Supervisor');
    }
    public function getProfileDiagnosis()
    {
        $diagnosis=$this->adminRepository->getProfileDiagnosis();
        if (!$diagnosis)
        {
//            throw new HttpResponseException($this->internalErrorResponse('NotFound Patient!'));
            return  $this->notFoundResponse(message: 'Diagnosis NotFound');
        }
        return  $this->resourceFoundResponse(data:$diagnosis,message:'Diagnosis');
    }


}
