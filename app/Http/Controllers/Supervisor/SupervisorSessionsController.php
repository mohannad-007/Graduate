<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SupervisorSessionsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function getSessionsNotAssignment(Request $request)
    {
        return $this->supervisorService->getSessionsNotAssignment($request->clinic_id);
    }
    public function getMySessions(Request $request)
    {
        return $this->supervisorService->getMySessions($request->clinic_id);
    }

}
