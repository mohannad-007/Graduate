<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentReferralController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }
    public function viewMyReferrals(Request $request)
    {
        return $this->userService->viewMyReferrals($request);
    }
    public function acceptMyReferral(Request $request)
    {
        $referral_id=$request->referral_id;

        return $this->userService->acceptMyReferral($referral_id);
    }
    public function rejectMyReferral(Request $request)
    {
        $referral_id=$request->referral_id;

        return $this->userService->rejectMyReferral($referral_id);
    }
}
