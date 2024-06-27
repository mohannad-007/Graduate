<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentOperationsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function createStudentInfo(Request $request)
    {
        $UN=$request->un;
        return $this->adminService->createStudentInfo($UN);
    }
    public function updateStudentInfo(Request $request)
    {
        $UN=$request->un;
        $id=$request->id;
        return $this->adminService->updateStudentInfo($UN,$id);
    }
    public function viewAllStudentInfo()
    {
        return $this->adminService->viewAllStudentInfo();
    }
    public function viewSpecificStudentInfo(Request $request)
    {
        $id=$request->id;
        return $this->adminService->viewSpecificStudentInfo($id);
    }
    public function deleteSpecificStudentInfo(Request $request)
    {
        $id=$request->id;
        return $this->adminService->deleteSpecificStudentInfo($id);
    }
    public function giveRuleDiagnosisToStudent(Request $request)
    {
        $id=$request->id;
        return $this->adminService->giveRuleDiagnosisToStudent($id);
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();
        $data = Excel::toArray([], $path);

        // Get the first sheet
        $rows = $data[0];

        // Skip the heading row
        foreach (array_slice($rows, 1) as $row) {
            Student::create([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'year' => $row[2],
                'university_number' => $row[3],
            ]);
        }

        return response()->json(['message' => 'Students imported successfully']);
    }


}
