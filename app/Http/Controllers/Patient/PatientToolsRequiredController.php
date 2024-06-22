<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientToolsRequiredController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected PatientService $userService)
    {
    }
    public function toolsRequireds(){

        $patient_id=auth()->user()->id;

        return $this->userService->toolsRequireds($patient_id);

    }
}
