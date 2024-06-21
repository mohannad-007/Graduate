<?php

namespace App\Services\Section;

use App\Repositories\Diagnosis\DiagnosisRepositoryInterface;
use App\Repositories\Section\SectionRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Exceptions\HttpResponseException;

class SectionService
{
    use RespondsWithHttpStatus;

    public function __construct(
        protected SectionRepositoryInterface $sectionRepository
    )
    {
    }

    public function register(array $data)
    {
        $token = null;
        $section = $this->sectionRepository->register($data);
        if (!$section) {
            throw new HttpResponseException($this->internalErrorResponse('The Section Cannot be created!'));
        }
        $token = $section->createToken('section-token', ['actAsSection'])->plainTextToken;
        $sectionInfo = ['email' => $section['email'], 'token' => $token];
        return $this->resourceCreatedResponse($sectionInfo, "Section Register Successful");
    }

    public function edit($id, array $data)
    {
        $section = $this->sectionRepository->edit($id, $data);
        if (!$section) {
            throw new HttpResponseException($this->internalErrorResponse('The Section Profile Cannot be Edited!'));
        }
        return $this->resourceCreatedResponse(message: "Section Profile Edited Successful");

    }

    public function delete($id)
    {
        $section = $this->sectionRepository->delete($id);
        if (!$section) {
            throw new HttpResponseException($this->internalErrorResponse('The Section Cannot be deleted!'));
        }
        return $this->resourceDeletedResponse("Section Deleted Successful");
    }

    public function login(array $data)
    {

        $section = $this->sectionRepository->login($data);
        if (!$section) {
            throw new HttpResponseException($this->unauthorizedResponse('Invalid Password!'));
        }
        $token = $section->createToken('$section-token', ['actAsSection'])->plainTextToken;
        if (!$token) {
            throw new HttpResponseException($this->internalErrorResponse('The Section Cannot be logged in!'));
        }
        return $this->resourceCreatedResponse(['token' => $token], "Section Login Successful");
    }

    public function showPatientsInCurrentChapter($section, $chapter)
    {

        $section = $this->sectionRepository->showPatientsInCurrentChapter($section, $chapter);
        if (!$section) {
            throw new HttpResponseException($this->notFoundResponse('Patients Not Found in this '));
        }
        return $this->successResponse(data: $section, message: "Patients in Current Chapter");
    }

    public function getSections()
    {

        $section = $this->sectionRepository->getSections();

        if (!$section) {

            throw new HttpResponseException($this->notFoundResponse('Sections Not Found'));

        }

        return $this->successResponse(data: $section, message: "Sections");
    }

    public function addReferralToStudent($student_id, $patient_cases_id)
    {
        $section = $this->sectionRepository->addReferralToStudent($student_id, $patient_cases_id);
        if (!$section) {

            throw new HttpResponseException($this->notFoundResponse('Cannot be Added Referral!'));

        }

        return $this->successResponse(data: $section, message: "Referral Added Successfully");
    }

    public function addTypeOfCases($type)
    {

        $section = $this->sectionRepository->addTypeOfCases($type);
        if (!$section) {

            throw new HttpResponseException($this->notFoundResponse('Cannot be Added Type Of Cases!'));

        }
        return $this->successResponse(data: $section, message: "Type Of Cases Added Successfully");
    }
    public function  addSuperVisorTimeToClinic(array $data)
    {

        $section = $this->sectionRepository->addSuperVisorTimeToClinic($data);
        if (!$section) {

            throw new HttpResponseException($this->internalErrorResponse('Cannot be Added SuperVisor Time To Clinic!'));

        }
        return $this->resourceCreatedResponse(data: $section, message: "SuperVisor Time To Clinic Added Successfully");
    }


}
