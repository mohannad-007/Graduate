<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class AllStudentViewController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function allStudentView()
    {
        return $this->userService->allStudentView();
    }
}
