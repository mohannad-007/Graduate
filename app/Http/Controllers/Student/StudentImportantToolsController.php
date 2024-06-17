<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentImportantToolsController extends Controller
{

    use RespondsWithHttpStatus;
    public function __construct(
        protected StudentService $userService
    ) {
    }

    public function addTools(Request $request){
        $validator = Validator::make($request->all(), [
            'details_of_tool'=>'required|string|max:255',
            'image_tool'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image_tool'))
        {
            $file = $request->file('image_tool');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->move(public_path('images'), $fileName);
            $url = url('images/' . $fileName);
        }
        $image_tool=$url;
        $details_of_tool=$request->input('details_of_tool');
        return $this->userService->addTools($details_of_tool,$image_tool);
    }

    public function getTools(){
        return $this->userService->getTools();
    }
    public function destroyTools(Request $request){
        $id=$request->id;
        return $this->userService->destroyTools($id);
    }

}
