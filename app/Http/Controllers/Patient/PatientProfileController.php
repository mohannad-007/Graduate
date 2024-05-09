<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientProfileRequest;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(
        protected PatientService $userService
    ) {
    }
    public function create(PatientProfileRequest $request)
    {
        $id=$request->user()->id;
        return $this->userService->create($id,$request->all());
    }

    public function showProfileInfo(){
        return $this->userService->showProfileInfo();
    }

}
