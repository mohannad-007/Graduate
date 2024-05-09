<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\SupervisorEditProfile;
use App\Services\Supervisor\SupervisorService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SupervisorProfileController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected SupervisorService $supervisorService

    ){}
    public function edit(SupervisorEditProfile $request)
    {
        $id = $request->id;
        return $this->supervisorService->edit($id, $request->all());

    }
}
