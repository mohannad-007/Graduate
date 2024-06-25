<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

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


}
