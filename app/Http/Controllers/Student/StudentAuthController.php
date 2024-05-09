<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientLoginRequest;
use App\Http\Requests\Patient\PatientRegisterRequest;
use App\Http\Requests\Student\StudentLoginRequest;
use App\Http\Requests\Student\StudentRegisterRequest;
use App\Services\Patient\PatientService;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentAuthController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $studentService

    ){}
    public function register(StudentRegisterRequest $request)
    {
        return $this->studentService->register($request->university_number,$request->all());
    }
    public function login(StudentLoginRequest $request)
    {
        return $this->studentService->login($request->all());

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logged out successfully');
    }

}
