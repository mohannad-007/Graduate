<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionSupervisorController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function  addSuperVisorTimeToClinic(Request $request)
    {
        return  $this->sectionService->addSuperVisorTimeToClinic($request->all());
    }
}
