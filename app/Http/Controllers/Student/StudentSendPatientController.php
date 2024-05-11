<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentSendPatientRequest;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentSendPatientController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentViewCases(Request $request){

        $validator = Validator::make($request->all(), [
         'types_of_cases_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
         $typeId=$request->input('types_of_cases_id');

        return $this->userService->studentViewCases($typeId);
    }

    public function studentSendCases(Request $request){

        $validator = Validator::make($request->all(), [
         'student_id'=>'required',
         'patient_cases_id'=>'required',
         'note'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
         $studentId=$request->input('student_id');
         $patientCasesId=$request->input('patient_cases_id');
         $note=$request->input('note');

        return $this->userService->studentSendCases($studentId,$patientCasesId,$note);
    }
}
