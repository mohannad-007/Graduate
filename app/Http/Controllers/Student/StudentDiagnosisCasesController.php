<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentDiagnosisCasesController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentDiagnosisCases(){

        $data = $this->userService->studentDiagnosisCases();
        return $data;
    }
}
