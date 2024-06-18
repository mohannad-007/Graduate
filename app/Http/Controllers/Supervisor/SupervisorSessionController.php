<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\SupervisorEditProfile;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SupervisorSessionController extends Controller
{


    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}
    public function getSessionToday(Request $request)
    {
        return $this->supervisorService->getSessionToday($request->all());

    }

    public function getPatientToday(Request $request)
    {
        return $this->supervisorService->getPatientToday($request->all());
    }
    public function getStudentsRelatedPatient(Request $request)
    {
        return $this->supervisorService->getStudentsRelatedPatient($request->all());
    }
    public function getSessionsRelatedPatientStudent(Request $request)
    {
        return $this->supervisorService->getSessionsRelatedPatientStudent($request->all());
    }

}
