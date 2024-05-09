<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\DiagnosisDeleteRequest;
use App\Http\Requests\Admin\Users\DiagnosisEditProfile;
use App\Http\Requests\Admin\Users\DiagnosisRegisterRequest;
use App\Http\Requests\Admin\Users\SectionDeleteRequest;
use App\Http\Requests\Admin\Users\SectionEditProfile;
use App\Http\Requests\Admin\Users\SectionRegisterRequest;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class AdminSectionsController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(
        protected SectionService $sectionService
    )
    {
    }

    public function register(SectionRegisterRequest $request)
    {
        return $this->sectionService->register($request->all());
    }
    public function edit(SectionEditProfile $request)
    {
        $id = $request->id;
        return $this->sectionService->edit($id, $request->all());

    }
    public function delete(SectionDeleteRequest $request)
    {
        return $this->sectionService->delete($request->all());
    }
}
