<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Services\Admin\AdminService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected AdminService $adminService

    ){}
    public function register(AdminRegisterRequest $request)
    {
        return $this->adminService->register($request->all());
    }
    public function login(AdminLoginRequest $request)
    {
        return $this->adminService->login($request->all());

    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logged out successfully');
    }
    //
}
