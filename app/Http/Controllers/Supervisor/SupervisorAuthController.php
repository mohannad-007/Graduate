<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentLoginRequest;
use App\Http\Requests\Supervisor\SupervisorLoginRequest;
use App\Services\Student\StudentService;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SupervisorAuthController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}
    public function login(SupervisorLoginRequest $request)
    {
        return $this->supervisorService->login($request->all());

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logged out successfully');
    }
}
