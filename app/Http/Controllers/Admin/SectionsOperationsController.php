<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionsOperationsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function getAllSections()
    {
        return $this->adminService->getAllSections();
    }
    public function deleteSpecificSections(Request $request)
    {
        $id=$request->id;
        return $this->adminService->deleteSpecificSections($id);
    }

}
