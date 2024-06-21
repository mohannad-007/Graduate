<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionStudentController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function addReferralToStudent(Request $request)
    {
        $student_id= $request->student_id;
        $patient_cases_id=$request->patient_cases_id;
        return $this
            ->sectionService
            ->addReferralToStudent($student_id,$patient_cases_id);
    }
}
