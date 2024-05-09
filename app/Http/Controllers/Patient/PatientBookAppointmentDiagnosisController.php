<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientBookAppointmentDiagnosisRequest;
use App\Models\PatientHealthRecords;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientBookAppointmentDiagnosisController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(protected PatientService $userService)
    {
    }
    //
    public function bookAppointment(PatientBookAppointmentDiagnosisRequest $request)
    {
        $data['patient_id']=auth()->user()->id;
        $data['reason']=$request->input('reason');
        $patient=auth()->user();
        if (!$patient
            || empty($patient->first_name)
            || empty($patient->last_name)
            || empty($patient->gender)
            || empty($patient->birthday)
            || empty($patient->image)) {
            return $this->forbiddenResponse(message: 'Please complete your profile');
        }
        $isHealthRecord=PatientHealthRecords::where('patient_id',$data['patient_id'])->first();
        if (!$isHealthRecord) {
            return $this->forbiddenResponse(message: 'Please create your health records');
        }
        return $this->userService->bookAppointment($data);
    }
}
