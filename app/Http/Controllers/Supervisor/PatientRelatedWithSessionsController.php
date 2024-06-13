<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientRelatedWithSessionsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function patientRelatedWithSessions(Request $request)
    {
        $patient_id=$request->patient_id;
        return $this->supervisorService->patientRelatedWithSessions($patient_id);
    }

}
