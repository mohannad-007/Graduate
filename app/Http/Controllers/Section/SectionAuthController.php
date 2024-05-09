<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnosis\DiagnosisLoginRequest;
use App\Http\Requests\Section\SectionLoginRequest;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionAuthController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function login(SectionLoginRequest $request)
    {
        return $this->sectionService->login($request->all());

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logged out successfully');
    }

}
