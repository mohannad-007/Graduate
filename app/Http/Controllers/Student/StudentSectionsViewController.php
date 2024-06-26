<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentSectionsViewController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function sectionsView(){

        return $this->userService->sectionsView();
    }
    public function getClinicsBySectionId(Request $request)
    {

        return $this->userService->getClinicsBySectionId($request->section_id);
    }
}
