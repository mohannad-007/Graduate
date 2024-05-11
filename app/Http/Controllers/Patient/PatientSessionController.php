<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientSessionRequest;
use App\Models\Sessions;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class PatientSessionController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(protected PatientService $userService)
    {}

    public function patientSessionRelatedWithStudent(PatientSessionRequest $request)
    {
        $student_id=$request->input('student_id');
        $patient_id = auth()->user()->id;
        return $this->userService->patientSessionRelatedWithStudent($patient_id,$student_id);
    }

//    public function test(Request $request)
//    {
//        $studentId = $request->input('student_id');
//        $patientId = auth()->user()->id;
//
//        $sessions = Sessions::join('referrals', 'sessions.referrals_id', '=', 'referrals.id')
//            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
//            ->where('patient_cases.patient_id', $patientId)
//            ->where('patient_cases.student_id', $studentId)
//            ->select('sessions.*')
//            ->with('supervisor','clinics.sections','referrals.patientCases')
//            ->get();
//
////        $responseData = $sessions->map(function ($session) {
////            $clinics = $session->clinics;
////            $sectionId = $clinics->sections->id; // استخراج section_id من العلاقة بين clinics و sections بشكل آمن
////            $clinics->section_id = $sectionId; // إضافة section_id إلى البيانات المسترجعة للعرض
////            return $session;
////        });
//
////        $responseData = $sessions->map(function ($session) {
////            unset($session['student_id']);
////            unset($session['patient_cases_id']);
////            unset($session['type_of_refarrals']);
////            unset($session['status_of_refarrals']);
////            unset($session['status_done']);
////            unset($session['patient_id']);
////            unset($session['types_of_cases_id']);
////            unset($session['diagnosis_appointments_id']);
////            unset($session['details_of_cases']);
////            return $session;
////        });
//
//        return response()->json($sessions);

//        return response()->json($sessions);

//    }



}
