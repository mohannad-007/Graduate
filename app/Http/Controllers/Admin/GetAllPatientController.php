<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Models\Patient;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class GetAllPatientController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService
    ){}

    public function getPatient()
    {
        return $this->adminService->getPatient();
    }

    public function searchPatient(Request $request)
    {
        $searchTerm = $request->input('search');
        if (empty($searchTerm)) {
            return response()->json(['message' => 'Search term is required'], 400);
        }
        return $this->adminService->searchPatient($searchTerm);
    }



}
