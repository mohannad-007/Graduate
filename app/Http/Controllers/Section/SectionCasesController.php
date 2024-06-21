<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Services\Section\SectionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class SectionCasesController extends Controller
{
    use RespondsWithHttpStatus;
    public function __construct(
        protected SectionService $sectionService

    ){}
    public function addTypeOfCases(Request $request)
    {
        return  $this->sectionService->addTypeOfCases($request->type);
    }
}
