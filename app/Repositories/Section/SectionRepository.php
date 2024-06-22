<?php

namespace App\Repositories\Section;

use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\PatientCases;
use App\Models\Referrals;
use App\Models\RequiredOperations;
use App\Models\Sections;
use App\Models\Student;
use App\Models\SupervisorTime;
use App\Models\TypesOfCases;
use Illuminate\Support\Facades\Hash;

class SectionRepository implements  SectionRepositoryInterface
{
    public function register(array $data)
    {
        unset($data['image_av']);
        $data['password']=Hash::make($data['password']);
        $section=Sections::create($data);
        return $section;
    }
    public function edit($id, array $data)
    {
        return $section=Sections::where('id',$id)->first()->update($data);
    }
    public function delete($id)
    {
        return Sections::destroy($id);
    }
    public function login(array $data)
    {
        $section=Sections::where('email',$data['email'])->first();
        if(!$section || !Hash::check($data['password'],$section->password))
            return null;
        return $section;
    }
    public function getSections()
    {
        return Sections::all();
    }
    public function showPatientsInCurrentChapter($section, $chapter)
    {
        $chapterPatients = PatientCases::whereHas('referrals', function ($query) use ($section, $chapter) {
            $query->where('section_id', $section)
                ->where('chapter', $chapter);
        })->with(['referrals' => function ($query) use ($section, $chapter) {
            $query->where('section_id', $section)
                ->where('chapter', $chapter);
        }, 'typeOfCase', 'patient'])->get();

//
//        $patientCases = PatientCases::with(['referrals','typesOfCases'])->get();
//        $patientCasesWithTypes = PatientCases::with('typesOfCases')->get();
//        $typesOfCasesWithSections = TypesOfCases::with('sections')->get();
////         تنسيق البيانات لإرجاع استجابة مفهومة
//        $response = $patientCases->map(function ($patientCase) {
//            return [
//                'patient_case_id' => $patientCase->id,
//                'details_of_cases' => $patientCase->details_of_cases,
//                'case_type' => $patientCase->typesOfCases->type,
//                'section_name' => $patientCase->typesOfCases->sections->name,
//                'referrals' => $patientCase->referrals->map(function ($referral) {
//                    return [
//                        'referral_id' => $referral->id,
//                        'status_of_refarrals' => $referral->status_of_refarrals,
//                    ];
//                }),
//            ];
//        });
//        // جلب جميع حالات المرضى مع الإحالات المرتبطة بها
//        $patientCases = PatientCases::with(['referrals', 'typesOfCases', 'typesOfCases.sections'])
//            ->get();
//
//        // تنسيق البيانات لإرجاع استجابة مفهومة
//        $response = $patientCases->map(function ($patientCase) {
//            return [
//                'patient_case' => $patientCase,
//                'referrals' => $patientCase->referrals,
//            ];
//        });
//        // جلب جميع حالات المرضى مع الإحالات المرتبطة بها وتصفية حسب section_id و chapter
//        $patientCases = PatientCases::with(['referrals', 'typesOfCases' => function ($query) use ($section) {
//            $query->where('section_id', $section);
//        }, 'typesOfCases.section'])
//            ->whereHas('typesOfCases.requiredOperations', function ($query) use ($chapter) {
//                $query->where('chapter', $chapter);
//            })
//            ->get();
//
//        // تنسيق البيانات لإرجاع استجابة مفهومة
//        $response = $patientCases->map(function ($patientCase) {
//            return [
//                'patient_case_id' => $patientCase->id,
//                'details_of_cases' => $patientCase->details_of_cases,
//                'case_type' => $patientCase->typesOfCases->type,
//                'section_name' => $patientCase->typesOfCases->sections->name,
//                'referrals' => $patientCase->referrals->map(function ($referral) {
//                    return [
//                        'referral_id' => $referral->id,
//                        'status_of_refarrals' => $referral->status_of_refarrals,
//                    ];
//                }),
//            ];
//        });
        if(!$chapterPatients)
            return null;
        return $chapterPatients;
    }
    public function addReferralToStudent($student_id,$patient_cases_id)
    {
        $data=[];
        $data['student_id']=$student_id;
        $data['patient_cases_id']=$patient_cases_id;
        $data['type_of_refarrals']='converted_from_section';
        $data['status_of_refarrals']='before_confirmation';
        $data['status_done']='not_finished';

        $referral=Referrals::create($data);
        return $referral;
    }
    public function addTypeOfCases($type)
    {
        $data=[];
        $data['type']=$type;
        $data['section_id']=auth()->user()->id;
        $typeOfCases=TypesOfCases::create($data);
        return $typeOfCases;
    }
    public function  addSuperVisorTimeToClinic(array $data)
    {
        $supervisorTime=SupervisorTime::create($data);
        return $supervisorTime;
    }
}


