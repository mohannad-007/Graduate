<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SessionDetailsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function sessionDetails(Request $request)
    {
        $session_id=$request->session_id;
        return $this->supervisorService->sessionDetails($session_id);
    }
    public function addSessionNotes(Request $request)
    {
        $session_id=$request->session_id;
        $notes=$request->notes;
        $evaluation=$request->evaluation;

        return $this->supervisorService->addSessionNotes($session_id,$notes,$evaluation);
    }




}
