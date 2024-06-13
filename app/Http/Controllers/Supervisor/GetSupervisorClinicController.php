<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class GetSupervisorClinicController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function getClinic()
    {
        return $this->supervisorService->getClinic();
    }


}
