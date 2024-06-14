<?php

namespace App\Http\Controllers\section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionPatientController extends Controller
{
     use RespondsWithHttpStatus;
        public function __construct(
            protected SectionService $sectionService

        ){}
    public function showPatientsInCurrentChapter(Request $request)
    {
        $chapter=$request->chapter;
        $section_id=$request->section_id;
        return $this->sectionService->showPatientsInCurrentChapter($section_id,$chapter);
    }
}
