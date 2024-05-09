<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\DiagnosisEditProfile;
use App\Http\Requests\Admin\Users\SupervisorEditProfile;
use App\Services\Diagnosis\DiagnosisService;
use Illuminate\Http\Request;

class DiagnosisProfileController extends Controller
{
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}

    public function edit(DiagnosisEditProfile $request)
    {
        $id = $request->id;
        return $this->diagnosisService->edit($id, $request->all());

    }
}
