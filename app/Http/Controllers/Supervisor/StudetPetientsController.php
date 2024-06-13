<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudetPetientsController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function studentPatient(Request $request)
    {
        $clinic_id=$request->clinic_id;
        return $this->supervisorService->studentPatient($clinic_id);
    }
}
