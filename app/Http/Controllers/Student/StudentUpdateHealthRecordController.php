<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientDisease;
use App\Models\PatientHealthRecords;
use App\Models\PatientMedication;
use App\Models\Radiographs;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class StudentUpdateHealthRecordController extends Controller
{
    //

    use RespondsWithHttpStatus;

    public function updateHealthRecord(Request $request)
    {
        $patientId = $request->input('patient_id');

        $radiograph = $request->radiograph;
        $medicine = $request->medicine;
        $diseases = $request->diseases;

        $responseData1= [];
        $responseData2 = [];
        $responseData3 = [];

        $patientRadiograph=Radiographs::where('patient_id',$patientId)->get();

        if ($patientRadiograph){
            Radiographs::where('patient_id',$patientId)->delete();

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
                        $radiographData['patient_id'] = $patientId;
                    }
                    $createData=Radiographs::create($radiographData);
                    $responseData1[] = $createData;
                }
            }
        }
        $patientMedicine=PatientMedication::where('patient_id',$patientId)->get();
        if ($patientMedicine){
            PatientMedication::where('patient_id',$patientId)->delete();

            if (!empty($medicine)){
                foreach ($medicine as $index => $medicineData)
                {
                    $fieldName = 'medicine.' . $index . '.medicine_image';
                    $name='medicine.' . $index . '.name';
                    $medicineData['patient_id'] = $patientId;
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
        }
        $patientDisease=PatientDisease::where('patient_id',$patientId)->with('preexistingDisease')->get();
        if ($patientDisease){
            PatientDisease::where('patient_id',$patientId)->delete();

            if (!empty($diseases)){
                foreach ($diseases as $index => $diseasesData)
                {
                    $fieldName = 'diseases.' . $index . '.preexisting_disease_id';
                    if ($request->input($fieldName))
                    {
                        $diseasesData['patient_id'] = $patientId;
                        $diseasesData['preexisting_disease_id'] = $request->input($fieldName);
                        $createData=PatientDisease::create($diseasesData);
                        $responseData3[] = $createData;
                    }
                }
            }
        }

        return $this->resourceCreatedResponse(
            data: [
                'radiograph' => $responseData1,
                'medicine'=>$responseData2,
                'patient_diseases'=>$responseData3,
            ],
            message: 'Health Record Updated Successfully');

    }



}
