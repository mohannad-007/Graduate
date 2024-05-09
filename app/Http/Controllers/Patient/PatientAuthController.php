<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientLoginRequest;
use App\Http\Requests\Patient\PatientRegisterRequest;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientAuthController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected PatientService $userService

    ){}
    public function register(PatientRegisterRequest $request)
    {
       return $this->userService->register($request->all());
    }
    public function logout(Request $request)
    {
            $request->user()->currentAccessToken()->delete();
            return $this->successResponse('Logged out successfully');
    }
    public function login(PatientLoginRequest $request)
    {
        return $this->userService->login($request->all());

    }
}
