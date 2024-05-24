<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientTestResultsAfterDiagnosisRequest;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientTestResultsAfterDiagnosisController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(protected PatientService $userService)
    {}

    public function showPatientCaseByPatientId()
    {
        $patient_id=auth()->user()->id;
        return $this->userService->showPatientCaseByPatientId($patient_id);
    }
}
