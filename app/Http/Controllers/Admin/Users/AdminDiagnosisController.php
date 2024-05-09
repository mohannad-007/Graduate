<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\DiagnosisDeleteRequest;
use App\Http\Requests\Admin\Users\DiagnosisEditProfile;
use App\Http\Requests\Admin\Users\DiagnosisRegisterRequest;
use App\Http\Requests\Admin\Users\SupervisorDeleteRequest;
use App\Http\Requests\Admin\Users\SupervisorEditProfile;
use App\Http\Requests\Admin\Users\SupervisorRegisterRequest;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class AdminDiagnosisController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(
        protected DiagnosisService $diagnosisService
    )
    {
    }
    public function register(DiagnosisRegisterRequest $request)
    {
        return $this->diagnosisService->register($request->all());
    }
    public function edit(DiagnosisEditProfile $request)
    {
        $id = $request->id;
        return $this->diagnosisService->edit($id, $request->all());

    }
    public function delete(DiagnosisDeleteRequest $request)
    {
        return $this->diagnosisService->delete($request->all());
    }
}
