<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class GetProfileOperationsController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function getProfileSections()
    {
        return $this->adminService->getProfileSections();
    }
    public function getProfileSupervisor()
    {
        return $this->adminService->getProfileSupervisor();
    }
    public function getProfileDiagnosis()
    {
        return $this->adminService->getProfileDiagnosis();
    }
}
