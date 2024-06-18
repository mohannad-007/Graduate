<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SupervisorSectionController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}
    public  function getMySections(Request $request)
    {
        return $supervisor = $this->supervisorService->getMySections(auth()->id());

    }
    public  function getClinicsBySectionId(Request $request)
    {
        return $supervisor = $this->supervisorService->getClinicsBySectionId($request->section_id);

    }
}
