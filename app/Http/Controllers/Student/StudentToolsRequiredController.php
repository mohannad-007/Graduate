<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LaboratoryToolsRequired;
use App\Models\PatientDisease;
use App\Models\PatientHealthRecords;
use App\Models\PatientMedication;
use App\Models\Radiographs;
use App\Traits\RespondsWithHttpStatus;
use http\Message;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentToolsRequiredController extends Controller
{
    use RespondsWithHttpStatus;

//    public function toolsRequired(Request $request)
//    {
//
//        $tools = $request->tools;
//        $responseData1= [];
//        $patientId=$request->input('patient_id');
//        $sessionId=$request->input('session_id');
//        if (empty($patientId)){
//            return throw new HttpResponseException($this->validationErrorResponse('patient_id is required'));
//
//        }
//        if (empty($sessionId)){
//            return throw new HttpResponseException($this->validationErrorResponse('session_id is required'));
//        }
//        if (!empty($tools) ){
//            foreach ($tools as $index => $toolsData)
//            {
//                $fieldName = 'tools.' . $index . '.image_tool';
//                $detailsOfTool = 'tools.' . $index . '.details_of_tool';
//                if ($request->hasFile($fieldName))
//                {
//                    $file = $request->file($fieldName);
//                    $fileName = $file->getClientOriginalName();
//                    $filePath = $file->move(public_path('images'), $fileName);
//                    $url = url('images/' . $fileName);
//                    $toolsData['image_tool'] = $url;
//                    $toolsData['student_id'] = auth()->user()->id;
//                    $toolsData['patient_id'] = $request->input('patient_id');
//                    $toolsData['session_id'] = $request->input('session_id');
//                    $toolsData['details_of_tool'] = $request->input($detailsOfTool);
//                }
//                $createData=LaboratoryToolsRequired::create($toolsData);
//                $responseData1[] = $createData;
//            }
//        }
//
//
//        return $this->resourceCreatedResponse(
//            data: [
//                'toolsRequired' => $responseData1,
//            ],
//            message: 'Tools Requested Successfully');
//
//    }

    public function toolsRequired(Request $request)
    {
        $tools = $request->tools;
        $responseData1 = [];

        $patientId = intval($request->patient_id ?? null);
        $sessionId = intval($request->session_id ?? null);

        if (empty($patientId)) {
            return throw new HttpResponseException($this->validationErrorResponse('patient_id is required'));
        }

        if (empty($sessionId)) {
            return throw new HttpResponseException($this->validationErrorResponse('session_id is required'));
        }

        if (!empty($tools)) {
            foreach ($tools as $index => $toolsData) {
                $fieldName = 'tools.' . $index . '.image_tool';
                $detailsOfTool = 'tools.' . $index . '.details_of_tool';

                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->move(public_path('images'), $fileName);
                    $url = url('images/' . $fileName);

                    $toolsData['image_tool'] = $url;
                    $toolsData['student_id'] = auth()->user()->id;
                    $toolsData['patient_id'] = $patientId;
                    $toolsData['session_id'] = $sessionId;
                    $toolsData['details_of_tool'] = $request->input($detailsOfTool);

                    $createData = LaboratoryToolsRequired::create($toolsData);
                    $responseData1[] = $createData;
                }
            }
        }

        return $this->resourceCreatedResponse(
            data: [
                'toolsRequired' => $responseData1,
            ],
            message: 'Tools Requested Successfully'
        );
    }

}
