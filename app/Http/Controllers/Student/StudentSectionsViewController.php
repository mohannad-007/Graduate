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

//        $id= auth()->user()->id;
//        dd($id);
        return $this->userService->sectionsView();
    }
}
