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
        $section_id=auth()->id();

        return $this->sectionService->showPatientsInCurrentChapter($section_id,$chapter);
    }
    public function showCasesInCurrentChapter(Request $request)
    {
        $chapter=$request->chapter;
        $section_id=auth()->id();

        return $this->sectionService->showCasesInCurrentChapter($section_id,$chapter);
    }
    public function showArchiveCasesDate(Request $request)
    {
        $date=$request->date;
        $section_id=auth()->id();

        return $this->sectionService->showArchiveCasesDate($section_id,$date);
    }
    public function showPatientCasesWithStudents(Request $request)
    {
        $section_id=auth()->id();

        return $this->sectionService->showPatientCasesWithStudents($section_id);
    }
}
