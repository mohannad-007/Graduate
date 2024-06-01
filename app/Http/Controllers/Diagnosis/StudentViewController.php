<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnosis\PatientAcceptAppointmentRequest;
use App\Services\Diagnosis\DiagnosisService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentViewController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}

    public function studentView()
    {
        return $this->diagnosisService->studentView();
    }

    public function studentTrueDiagnosisView()
    {
        return $this->diagnosisService->studentTrueDiagnosisView();
    }

}
