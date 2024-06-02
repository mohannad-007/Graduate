<?php

namespace App\Http\Controllers\Diagnosis;

use App\Http\Controllers\Controller;
use App\Services\Diagnosis\DiagnosisService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentGiveRulesDiagnosisController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected DiagnosisService $diagnosisService

    ){}

    public function studentGiveRules(Request $request)
    {

        $studentIds = $request->input('student_ids', []);
        if (empty($studentIds)) {
            return response()->json(['error' => 'No student IDs provided'], 400);
        }
        return $this->diagnosisService->studentGiveRules($studentIds);
    }


//    public function updateDiagnosis(Request $request)
//    {
//        // الحصول على مصفوفة معرفات الطلاب من الطلب
//        $studentIds = $request->input('student_ids', []);
//
//        // التحقق من أن المصفوفة ليست فارغة
//        if (empty($studentIds)) {
//            return response()->json(['error' => 'No student IDs provided'], 400);
//        }
//
//        // تحديث حقل diagnosis للطلاب المحددين
//        $updatedCount = Student::whereIn('id', $studentIds)
//            ->update(['diagnosis' => true]);
//
//        // إعادة استجابة JSON مع رسالة وعدد السجلات المحدثة
//        return response()->json([
//            'message' => 'Diagnosis status updated successfully',
//            'updated_count' => $updatedCount
//        ]);
//    }



}
