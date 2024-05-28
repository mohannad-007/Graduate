<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\DiagnosisEditProfile;
use App\Services\Diagnosis\DiagnosisService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientViewPendingController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}

    public function pendingPatientView()
    {
        return $this->diagnosisService->pendingPatientView();
    }
}
