<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientVisetedController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected PatientService $userService)
    {
    }
    public function viseted(){

        $patient_id=auth()->user()->id;

        return $this->userService->viseted($patient_id);
    }

    public function archiveVisited(){

        $patient_id=auth()->user()->id;

        return $this->userService->archiveVisited($patient_id);
    }
}
