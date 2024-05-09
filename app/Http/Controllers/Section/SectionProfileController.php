<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\DiagnosisEditProfile;
use App\Http\Requests\Admin\Users\SectionEditProfile;
use App\Services\Section\SectionService;
use Illuminate\Http\Request;

class SectionProfileController extends Controller
{
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function edit(SectionEditProfile $request)
    {
        $id = $request->id;
        return $this->sectionService->edit($id, $request->all());

    }
}
