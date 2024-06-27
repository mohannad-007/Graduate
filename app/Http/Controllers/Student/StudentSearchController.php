<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentSearchController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function searchStudent(Request $request)
    {
        // استرداد قيمة البحث من الطلب
        $searchTerm = $request->input('search');

        // التحقق من أن قيمة البحث غير فارغة
        if (empty($searchTerm)) {
            return response()->json(['message' => 'Search term is required'], 400);
        }

        // البحث عن الطلاب الذين تطابق أسماؤهم المدخلات
        $students = Student::where('first_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
            ->get();

        // التحقق من وجود نتائج
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No student found'], 404);
        }

        // إرجاع النتائج
        return response()->json($students);
    }


}
