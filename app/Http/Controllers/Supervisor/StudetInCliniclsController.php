<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudetInCliniclsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}

    public function studentInClinics()
    {
        return $this->supervisorService->studentInClinics();
    }

}
