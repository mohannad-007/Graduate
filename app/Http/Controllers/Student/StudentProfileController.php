<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientProfileRequest;
use App\Http\Requests\Student\StudentProfileRequest;
use App\Services\Patient\PatientService;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }
    //
    public function edit(StudentProfileRequest $request)
    {
        $id=$request->user()->id;
        //  dd($request->image);
        return $this->userService->edit($id,$request->all());

    }
}
