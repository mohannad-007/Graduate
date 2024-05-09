<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\SupervisorDeleteRequest;
use App\Http\Requests\Admin\Users\SupervisorEditProfile;
use App\Http\Requests\Admin\Users\SupervisorRegisterRequest;
use App\Services\Admin\AdminService;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class AdminSupervisorsController extends Controller
{

    use RespondsWithHttpStatus;

    public function __construct(
        protected SupervisorService $supervisorService
    )
    {
    }
    public function register(SupervisorRegisterRequest $request)
    {
        return $this->supervisorService->register($request->all());
    }
    public function delete(SupervisorDeleteRequest $request)
    {
        return $this->supervisorService->delete($request->all());
    }
    public function edit(SupervisorEditProfile $request)
    {
        $id = $request->id;
        return $this->supervisorService->edit($id, $request->all());

    }
}
