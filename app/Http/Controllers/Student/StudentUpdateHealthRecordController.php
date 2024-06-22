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

//    public function updateHealthRecord(Request $request)
//    {
//        $patientId = $request->input('patient_id');
//
//        $radiograph = $request->radiograph;
//        $medicine = $request->medicine;
//        $diseases = $request->diseases;
//
//        $responseData1= [];
//        $responseData2 = [];
//        $responseData3 = [];
//
//        $patientRadiograph=Radiographs::where('patient_id',$patientId)->get();
//
//        if ($patientRadiograph){
//            Radiographs::where('patient_id',$patientId)->delete();
//
//            if (!empty($radiograph)){
//                foreach ($radiograph as $index => $radiographData)
//                {
//                    $fieldName = 'radiograph.' . $index . '.radiograph_image';
//                    if ($request->hasFile($fieldName))
//                    {
//                        $file = $request->file($fieldName);
//                        $fileName = $file->getClientOriginalName();
//                        $filePath = $file->move(public_path('images'), $fileName);
//                        $url = url('images/' . $fileName);
//                        $radiographData['radiograph_image'] = $url;
//                        $radiographData['patient_id'] = $patientId;
//                    }
//                    $createData=Radiographs::create($radiographData);
//                    $responseData1[] = $createData;
//                }
//            }
//        }
//        $patientMedicine=PatientMedication::where('patient_id',$patientId)->get();
//        if ($patientMedicine){
//            PatientMedication::where('patient_id',$patientId)->delete();
//
//            if (!empty($medicine)){
//                foreach ($medicine as $index => $medicineData)
//                {
//                    $fieldName = 'medicine.' . $index . '.medicine_image';
//                    $name='medicine.' . $index . '.name';
//                    $medicineData['patient_id'] = $patientId;
//                    if ($request->hasFile($fieldName) && $request->input($name))
//                    {
//                        $file = $request->file($fieldName);
//                        $fileName = $file->getClientOriginalName();
//                        $filePath = $file->move(public_path('images'), $fileName);
//                        $url = url('images/' . $fileName);
//                        $medicineData['medicine_image'] = $url;
//                        $medicineData['name'] = $request->input($name);
//                        $createData=PatientMedication::create($medicineData);
//                        $responseData2[] = $createData;
//
//                    }
//                }
//            }
//        }
//        $patientDisease=PatientDisease::where('patient_id',$patientId)->with('preexistingDisease')->get();
//        if ($patientDisease){
//            PatientDisease::where('patient_id',$patientId)->delete();
//
//            if (!empty($diseases)){
//                foreach ($diseases as $index => $diseasesData)
//                {
//                    $fieldName = 'diseases.' . $index . '.preexisting_disease_id';
//                    if ($request->input($fieldName))
//                    {
//                        $diseasesData['patient_id'] = $patientId;
//                        $diseasesData['preexisting_disease_id'] = $request->input($fieldName);
//                        $createData=PatientDisease::create($diseasesData);
//                        $responseData3[] = $createData;
//                    }
//                }
//            }
//        }
//
//        return $this->resourceCreatedResponse(
//            data: [
//                'radiograph' => $responseData1,
//                'medicine'=>$responseData2,
//                'patient_diseases'=>$responseData3,
//            ],
//            message: 'Health Record Updated Successfully');
//
//    }



//    public function updateHealthRecord(Request $request)
//    {
//        $patientId = $request->input('patient_id');
//
//        $radiograph = $request->radiograph;
//        $medicine = $request->medicine;
//        $diseases = $request->diseases;
//
//        $responseData1 = [];
//        $responseData2 = [];
//        $responseData3 = [];
//
//        // معالجة Radiographs
//        if (!empty($radiograph)) {
//            foreach ($radiograph as $index => $radiographData) {
//                $fieldName = 'radiograph.' . $index . '.radiograph_image';
//                if ($request->hasFile($fieldName)) {
//                    $file = $request->file($fieldName);
//                    $fileName = $file->getClientOriginalName();
//                    $filePath = $file->move(public_path('images'), $fileName);
//                    $url = url('images/' . $fileName);
//                    $radiographData['radiograph_image'] = $url;
//                    $radiographData['patient_id'] = $patientId;
//                }
//
//                // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
//                $existingRadiograph = Radiographs::where('patient_id', $patientId)
//                    ->where('radiograph_image', $radiographData['radiograph_image'])
//                    ->first();
//
//                if ($existingRadiograph) {
//                    $existingRadiograph->update($radiographData);
//                    $responseData1[] = $existingRadiograph;
//                } else {
//                    $createData = Radiographs::create($radiographData);
//                    $responseData1[] = $createData;
//                }
//            }
//        }
//
//        // معالجة PatientMedication
//        if (!empty($medicine)) {
//            foreach ($medicine as $index => $medicineData) {
//                $fieldName = 'medicine.' . $index . '.medicine_image';
//                $name = 'medicine.' . $index . '.name';
//                $medicineData['patient_id'] = $patientId;
//                if ($request->hasFile($fieldName) && $request->input($name)) {
//                    $file = $request->file($fieldName);
//                    $fileName = $file->getClientOriginalName();
//                    $filePath = $file->move(public_path('images'), $fileName);
//                    $url = url('images/' . $fileName);
//                    $medicineData['medicine_image'] = $url;
//                    $medicineData['name'] = $request->input($name);
//                }
//
//                // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
//                $existingMedicine = PatientMedication::where('patient_id', $patientId)
//                    ->where('name', $medicineData['name'])
//                    ->first();
//
//                if ($existingMedicine) {
//                    $existingMedicine->update($medicineData);
//                    $responseData2[] = $existingMedicine;
//                } else {
//                    $createData = PatientMedication::create($medicineData);
//                    $responseData2[] = $createData;
//                }
//            }
//        }
//
//        // معالجة PatientDisease
//        if (!empty($diseases)) {
//            foreach ($diseases as $index => $diseasesData) {
//                $fieldName = 'diseases.' . $index . '.preexisting_disease_id';
//                if ($request->input($fieldName)) {
//                    $diseasesData['patient_id'] = $patientId;
//                    $diseasesData['preexisting_disease_id'] = $request->input($fieldName);
//
//                    // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
//                    $existingDisease = PatientDisease::where('patient_id', $patientId)
//                        ->where('preexisting_disease_id', $diseasesData['preexisting_disease_id'])
//                        ->first();
//
//                    if ($existingDisease) {
//                        $existingDisease->update($diseasesData);
//                        $responseData3[] = $existingDisease;
//                    } else {
//                        $createData = PatientDisease::create($diseasesData);
//                        $responseData3[] = $createData;
//                    }
//                }
//            }
//        }
//
//        return $this->resourceCreatedResponse(
//            data: [
//                'radiograph' => $responseData1,
//                'medicine' => $responseData2,
//                'patient_diseases' => $responseData3,
//            ],
//            message: 'Health Record Updated Successfully'
//        );
//    }


    public function updateHealthRecord(Request $request)
    {
        $patientId = $request->input('patient_id');

        $radiograph = $request->radiograph;
        $medicine = $request->medicine;
        $diseases = $request->diseases;

        $responseData1 = [];
        $responseData2 = [];
        $responseData3 = [];

        // معالجة Radiographs
        if (!empty($radiograph)) {
            foreach ($radiograph as $index => $radiographData) {
                $fieldName = 'radiograph.' . $index . '.radiograph_image';
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->move(public_path('images'), $fileName);
                    $url = url('images/' . $fileName);
                    $radiographData['radiograph_image'] = $url;
                }

                $radiographData['patient_id'] = $patientId;

                // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
                $existingRadiograph = Radiographs::where('patient_id', $patientId)
                    ->where('radiograph_image', $radiographData['radiograph_image'])
                    ->first();

                if ($existingRadiograph) {
                    $existingRadiograph->update($radiographData);
                    $existingRadiograph->save(); // أضف حفظ السجل لضمان التحديث
                    $responseData1[] = $existingRadiograph;
                } else {
                    $createData = Radiographs::create($radiographData);
                    $responseData1[] = $createData;
                }
            }
        }

        // معالجة PatientMedication
        if (!empty($medicine)) {
            foreach ($medicine as $index => $medicineData) {
                $fieldName = 'medicine.' . $index . '.medicine_image';
                $name = 'medicine.' . $index . '.name';
                $medicineData['patient_id'] = $patientId;
                if ($request->hasFile($fieldName) && $request->input($name)) {
                    $file = $request->file($fieldName);
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->move(public_path('images'), $fileName);
                    $url = url('images/' . $fileName);
                    $medicineData['medicine_image'] = $url;
                }
                $medicineData['name'] = $request->input($name);

                // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
                $existingMedicine = PatientMedication::where('patient_id', $patientId)
                    ->where('name', $medicineData['name'])
                    ->first();

                if ($existingMedicine) {
                    $existingMedicine->update($medicineData);
                    $existingMedicine->save(); // أضف حفظ السجل لضمان التحديث
                    $responseData2[] = $existingMedicine;
                } else {
                    $createData = PatientMedication::create($medicineData);
                    $responseData2[] = $createData;
                }
            }
        }

        // معالجة PatientDisease
        if (!empty($diseases)) {
            foreach ($diseases as $index => $diseasesData) {
                $fieldName = 'diseases.' . $index . '.preexisting_disease_id';
                if ($request->input($fieldName)) {
                    $diseasesData['patient_id'] = $patientId;
                    $diseasesData['preexisting_disease_id'] = $request->input($fieldName);

                    // تحقق من وجود السجل وقم بالتحديث أو الإنشاء
                    $existingDisease = PatientDisease::where('patient_id', $patientId)
                        ->where('preexisting_disease_id', $diseasesData['preexisting_disease_id'])
                        ->first();

                    if ($existingDisease) {
                        $existingDisease->update($diseasesData);
                        $existingDisease->save(); // أضف حفظ السجل لضمان التحديث
                        $responseData3[] = $existingDisease;
                    } else {
                        $createData = PatientDisease::create($diseasesData);
                        $responseData3[] = $createData;
                    }
                }
            }
        }

        return $this->resourceCreatedResponse(
            data: [
                'radiograph' => $responseData1,
                'medicine' => $responseData2,
                'patient_diseases' => $responseData3,
            ],
            message: 'Health Record Updated Successfully'
        );
    }



}
