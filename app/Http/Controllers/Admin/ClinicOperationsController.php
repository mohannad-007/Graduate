<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class ClinicOperationsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function getClinic()
    {
        return $this->adminService->getClinic();
    }
    public function getSpecificClinic(Request $request)
    {
        $clinicID=$request->clinicID;
        return $this->adminService->getSpecificClinic($clinicID);
    }
    public function deleteSpecificClinic(Request $request)
    {
        $clinicID=$request->clinicID;
        return $this->adminService->deleteSpecificClinic($clinicID);
    }
    public function updateSpecificClinic(Request $request)
    {
        $clinicID=$request->clinicID;
        $number=$request->number;
        return $this->adminService->updateSpecificClinic($clinicID,$number);
    }
    public function createClinic(Request $request)
    {
        $sectionID=$request->sectionID;
        $number=$request->number;
        return $this->adminService->createClinic($sectionID,$number);
    }

}
