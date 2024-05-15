<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentPatientSessionsRequest;
use App\Http\Requests\Student\StudentPatientToolsRequiredRequest;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentPatientSessionsController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentPatientSessions(StudentPatientSessionsRequest $request){

        $patientId=$request->patient_id;
        $data = $this->userService->studentPatientSessions($patientId);
        return $data;
    }
}
