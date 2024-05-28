<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Services\Diagnosis\DiagnosisService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientViewAcceptedController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}

    public function acceptPatientView()
    {
        return $this->diagnosisService->acceptPatientView();
    }

}
