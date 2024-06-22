<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentAppointmentRequest;
use App\Http\Requests\Student\StudentPatientSessionsRequest;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentAppointmentController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function studentAppointments(StudentAppointmentRequest $request){

        $history=$request->history;
//        $d=Carbon::parse($history)->toDateString();
//        dd($d);
//        dd($history);
        $data = $this->userService->studentAppointments($history);
        return $data;
    }
}
