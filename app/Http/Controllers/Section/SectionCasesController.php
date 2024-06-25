<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionCasesController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function addTypeOfCases(Request $request)
    {
        return  $this->sectionService->addTypeOfCases($request->type);
    }
    public function showSectionTypeOfCases(Request $request)
    {
        $section_id=auth()->id();
        return $this->sectionService->showSectionTypeOfCases($section_id);
    }
    public function showClinicsInSection(Request $request)
    {
        $section_id=auth()->id();
        return $this->sectionService->showClinicsInSection($section_id);
    }
    public function deleteTypeOfCases(Request $request)
    {
        return  $this->sectionService->deleteTypeOfCases($request->type_id);
    }
    public function updateTypeOfCases(Request $request)
    {
        return  $this->sectionService->updateTypeOfCases($request->type_id,$request->type);
    }

}
