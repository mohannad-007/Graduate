<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected PatientService $userService)
    {
    }
    public function myAppointment(){

        $patient_id=auth()->user()->id;

        return $this->userService->myAppointment($patient_id);

    }
}
