<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function addSession(Request $request)
    {

        return $this->userService->addSession($request->all());
    }
    public function updateSession(Request $request)
    {

        return $this->userService->updateSession($request->all());
    }

}
