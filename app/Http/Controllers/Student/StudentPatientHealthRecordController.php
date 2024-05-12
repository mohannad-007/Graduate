<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentPatientHealthRecordRequest;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentPatientHealthRecordController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentPatientHealthRecord(StudentPatientHealthRecordRequest $request){

        $patientId=$request->patient_id;
        $data = $this->userService->studentPatientHealthRecord($patientId);
        return $data;
    }

}
