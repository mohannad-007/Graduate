<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientProfileRequest;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientRelatedWithStudentController extends Controller
{

    use RespondsWithHttpStatus;

    public function __construct(
        protected PatientService $userService
    ) {
    }
    public function patientRelatedWithStudent()
    {
        $patientId=auth()->user()->id;
        return $this->userService->patientRelatedWithStudent($patientId);
    }

}
