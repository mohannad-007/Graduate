<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ContinuousMedication;
use App\Models\PatientDisease;
use App\Models\PatientHealthRecords;
use App\Models\PatientMedication;
use App\Models\PrescriptionMedicines;
use App\Models\Radiographs;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
   use RespondsWithHttpStatus;

    public function createHealthRecord(Request $request)
    {
        $radiograph = $request->radiograph;
        $medicine = $request->medicine;
        $diseases = $request->diseases;

        $responseData1= [];
        $responseData2 = [];
        $responseData3 = [];

        if (!empty($radiograph)){
            foreach ($radiograph as $index => $radiographData)
            {
                $fieldName = 'radiograph.' . $index . '.radiograph_image';
                if ($request->hasFile($fieldName))
                {
                    $file = $request->file($fieldName);
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->move(public_path('images'), $fileName);
                    $url = url('images/' . $fileName);
                    $radiographData['radiograph_image'] = $url;
                    $radiographData['patient_id'] = auth()->user()->id;
                }
                   $createData=Radiographs::create($radiographData);
                $responseData1[] = $createData;
            }
        }
        if (!empty($medicine)){
            foreach ($medicine as $index => $medicineData)
            {
                $fieldName = 'medicine.' . $index . '.medicine_image';
                $name='medicine.' . $index . '.name';
                $medicineData['patient_id'] = auth()->user()->id;
                if ($request->hasFile($fieldName) && $request->input($name))
                {
                    $file = $request->file($fieldName);
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->move(public_path('images'), $fileName);
                    $url = url('images/' . $fileName);
                    $medicineData['medicine_image'] = $url;
                    $medicineData['name'] = $request->input($name);
                    $createData=PatientMedication::create($medicineData);
                    $responseData2[] = $createData;

                }
            }
        }
        if (!empty($diseases)){
            foreach ($diseases as $index => $diseasesData)
            {
                $fieldName = 'diseases.' . $index . '.preexisting_disease_id';
                if ($request->input($fieldName))
                {
                    $diseasesData['patient_id'] = auth()->user()->id;
                    $diseasesData['preexisting_disease_id'] = $request->input($fieldName);
                    $createData=PatientDisease::create($diseasesData);
                    $responseData3[] = $createData;
                }
            }
        }
        PatientHealthRecords::create([
           'patient_id'=>auth()->user()->id,
            'is_healthRecord'=>true,
        ]);

        return $this->resourceCreatedResponse(
            data: [
            'radiograph' => $responseData1,
            'medicine'=>$responseData2,
            'patient_diseases'=>$responseData3,
            ],
            message: 'Health Record Created Successfully');

//        return response()->json([
//            'radiograph' => $responseData1,
//            'medicine'=>$responseData2,
//            'patient_diseases'=>$responseData3,
//        ]);
    }












}
