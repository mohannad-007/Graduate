<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnosis\DiagnosisLoginRequest;
use App\Http\Requests\Supervisor\SupervisorLoginRequest;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class DiagnosisAuthController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}
    public function login(DiagnosisLoginRequest $request)
    {
        return $this->diagnosisService->login($request->all());

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logged out successfully');
    }
}
