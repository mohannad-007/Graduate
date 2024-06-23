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

}
