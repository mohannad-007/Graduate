<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Services\Admin\AdminService;
use App\Services\Patient\PatientService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;
//use tcg/voyager/src/Http/Controllers/VoyagerBreadController;
class AdminProfileController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function edit(AdminProfileRequest $request)
    {
        $id = $request->user()->id;
        return $this->adminService->edit($id, $request->all());
    }
}
