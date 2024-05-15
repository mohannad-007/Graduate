<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentPatientHealthRecordRequest;
use App\Http\Requests\Student\StudentPatientToolsRequiredRequest;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentPatientToolsRequiredController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentPatientToolsRequired(StudentPatientToolsRequiredRequest $request){

        $patientId=$request->patient_id;
        $sessionId=$request->session_id;
        $data = $this->userService->studentPatientToolsRequired($patientId,$sessionId);
        return $data;
    }

}
