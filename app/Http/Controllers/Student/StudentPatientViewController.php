<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentPatientViewController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function convertFromSection(){

        return $this->userService->convertFromSection();
    }

    public function convertFromStudent(){

        return $this->userService->convertFromStudent();
    }

}
