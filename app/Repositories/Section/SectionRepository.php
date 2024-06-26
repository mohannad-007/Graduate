<?php

namespace App\Repositories\Section;

use App\Models\Clinics;
use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\PatientCases;
use App\Models\PatientTransferRequests;
use App\Models\Referrals;
use App\Models\RequiredOperations;
use App\Models\Sections;
use App\Models\Student;
use App\Models\SupervisorTime;
use App\Models\TypesOfCases;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SectionRepository implements  SectionRepositoryInterface
{
    public function register(array $data)
    {
        unset($data['image_av']);
        $data['password'] = Hash::make($data['password']);
        $section = Sections::create($data);
        return $section;
    }

    public function edit($id, array $data)
    {
        return $section = Sections::where('id', $id)->first()->update($data);
    }

    public function delete($id)
    {
        return Sections::destroy($id);
    }

    public function login(array $data)
    {
        $section = Sections::where('email', $data['email'])->first();
        if (!$section || !Hash::check($data['password'], $section->password))
            return null;
        return $section;
    }

    public function getSections()
    {
        return Sections::all();
    }

    public function addReferralToStudent($student_id, $patient_cases_id)
    {
        $data = [];
        $data['student_id'] = $student_id;
        $data['patient_cases_id'] = $patient_cases_id;
        $data['type_of_refarrals'] = 'converted_from_section';
        $data['status_of_refarrals'] = 'before_confirmation';
        $data['status_done'] = 'not_finished';

        $referral = Referrals::create($data);
        return $referral;
    }

    public function addTypeOfCases($type)
    {
        $data = [];
        $data['type'] = $type;
        $data['section_id'] = auth()->user()->id;
        $typeOfCases = TypesOfCases::create($data);
        return $typeOfCases;
    }

    public function addSuperVisorTimeToClinic(array $data)
    {
        $supervisorTime = SupervisorTime::create($data);
        return $supervisorTime;
    }

    public function showPatientsInCurrentChapter($section, $chapter)
    {
        $currentYear = date('Y'); // السنة الحالية
        $patients = Patient::join('patient_cases', 'patient.id', '=', 'patient_cases.patient_id')
            ->join('referrals', 'patient_cases.id', '=', 'referrals.patient_cases_id')
            ->join('referral_required_operations', 'referrals.id', '=', 'referral_required_operations.referral_id')
            ->join('required_operations', 'referral_required_operations.required_operation_id', '=', 'required_operations.id')
            ->join('types_of_cases', 'required_operations.types_of_cases_id', '=', 'types_of_cases.id')
            ->where('referrals.status_of_refarrals', 'confirmed')
            ->where('required_operations.chapter', $chapter)
            ->whereYear('required_operations.date', $currentYear) // إضافة شرط السنة الحالية
            ->where('types_of_cases.section_id', $section) // إضافة شرط section_id
            ->select('patient.*')
            ->distinct()
            ->get();
        return $patients;
    }

    public function showCasesInCurrentChapter($section, $chapter)
    {
        $currentYear = date('Y'); // السنة الحالية
        $patients = Patient::join('patient_cases', 'patient.id', '=', 'patient_cases.patient_id')
            ->join('referrals', 'patient_cases.id', '=', 'referrals.patient_cases_id')
            ->join('referral_required_operations', 'referrals.id', '=', 'referral_required_operations.referral_id')
            ->join('required_operations', 'referral_required_operations.required_operation_id', '=', 'required_operations.id')
            ->join('types_of_cases', 'required_operations.types_of_cases_id', '=', 'types_of_cases.id')
            ->join('student', 'referrals.student_id', '=', 'student.id') // انضمام جدول students باستخدام student_id من جدول referrals
            ->where('referrals.status_of_refarrals', 'confirmed')
//            ->where('referrals.status_done', 'not_finished')
            ->where('required_operations.chapter', $chapter)
            ->whereYear('required_operations.date', $currentYear) // إضافة شرط السنة الحالية
            ->where('types_of_cases.section_id', $section) // إضافة شرط section_id
            ->select(
                DB::raw("CONCAT(patient.first_name, ' ', patient.last_name) as patient_full_name"),
                'patient_cases.*',
                'types_of_cases.type as type_of_case',
                'student.*',
                'referrals.*'
            )
            ->distinct()
            ->get();
        return $patients;

    }

    public function showArchiveCasesDate($section, $dateInput)
    {

        try {
            // تحقق إذا كان التاريخ فارغًا
            if (empty($dateInput)) {
                // بناء الاستعلام بدون تصفية التاريخ
                $casesWithDetails = PatientCases::join('referrals', 'patient_cases.id', '=', 'referrals.patient_cases_id')
                    ->join('student', 'referrals.student_id', '=', 'student.id') // انضمام للحصول على معلومات الطالب
                    ->join('types_of_cases', 'patient_cases.types_of_cases_id', '=', 'types_of_cases.id')
                    ->join('sections', 'types_of_cases.section_id', '=', 'sections.id')
                    ->join('patient', 'patient_cases.patient_id', '=', 'patient.id')
                    ->where('sections.id', $section)
                    ->where(function ($query) {
                        $query->where(function ($q) {
                            $q->where('referrals.status_of_refarrals', 'confirmed')
                                ->where('referrals.status_done', 'finished');
                        })->orWhere('referrals.status_of_refarrals', 'sorry');
                    })
                    ->select(
                        'patient_cases.*',
                        'referrals.type_of_refarrals',
                        'referrals.status_of_refarrals',
                        'referrals.status_done',
                        'referrals.updated_at as referral_updated_at', // لإظهار تاريخ التحديث للإحالة
                        'types_of_cases.type as case_type',
                        'sections.name as section_name',
                        'student.first_name as student_first_name', // معلومات الطالب
                        'student.last_name as student_last_name',
                        'student.email as student_email',
                        'student.year as student_year',
                        'student.specialization as student_specialization',
                        'patient.first_name as patient_first_name', // معلومات المريض
                        'patient.last_name as patient_last_name',
                        'patient.email as patient_email',
                        'patient.gender as patient_gender',
                        'patient.birthday as patient_birthday'
                    )
                    ->get();
            } else {
                // تحليل التاريخ باستخدام Carbon
                $date = Carbon::parse($dateInput);

                // بناء الاستعلام مع تصفية التاريخ
                $casesWithDetails = PatientCases::join('referrals', 'patient_cases.id', '=', 'referrals.patient_cases_id')
                    ->join('student', 'referrals.student_id', '=', 'student.id') // انضمام للحصول على معلومات الطالب
                    ->join('types_of_cases', 'patient_cases.types_of_cases_id', '=', 'types_of_cases.id')
                    ->join('sections', 'types_of_cases.section_id', '=', 'sections.id')
                    ->join('patient', 'patient_cases.patient_id', '=', 'patient.id')
                    ->where('sections.id', $section) // استبدل رقم 1 بالـ section_id المطلوب
                    ->where(function ($query) {
                        $query->where(function ($q) {
                            $q->where('referrals.status_of_refarrals', 'confirmed')
                                ->where('referrals.status_done', 'finished');
                        })->orWhere('referrals.status_of_refarrals', 'sorry');
                    })
                    ->where(function ($query) use ($date, $dateInput) {
                        // التحقق إذا كان المدخل يحتوي على يوم
                        if (strlen($dateInput) == 10) { // تنسيق YYYY-MM-DD
                            $query->whereDate('referrals.updated_at', '=', $date);
                        } elseif (strlen($dateInput) == 7) { // تنسيق YYYY-MM
                            $query->whereYear('referrals.updated_at', '=', $date->year)
                                ->whereMonth('referrals.updated_at', '=', $date->month);
                        } elseif (strlen($dateInput) == 4) { // تنسيق YYYY فقط
                            $query->whereYear('referrals.updated_at', '=', $date->year);
                        }
                    })
                    ->select(
                        'patient_cases.*',
                        'referrals.type_of_refarrals',
                        'referrals.status_of_refarrals',
                        'referrals.status_done',
                        'referrals.updated_at as referral_updated_at', // لإظهار تاريخ التحديث للإحالة
                        'types_of_cases.type as case_type',
                        'sections.name as section_name',
                        'student.first_name as student_first_name', // معلومات الطالب
                        'student.last_name as student_last_name',
                        'student.email as student_email',
                        'student.year as student_year',
                        'student.specialization as student_specialization',
                        'patient.first_name as patient_first_name', // معلومات المريض
                        'patient.last_name as patient_last_name',
                        'patient.email as patient_email',
                        'patient.gender as patient_gender',
                        'patient.birthday as patient_birthday'
                    )
                    ->get();
            }

            return $casesWithDetails;
        } catch (\Exception $e) {
            // في حالة عدم القدرة على تحليل التاريخ
            return response()->json(['error' => 'Invalid date format. Please use YYYY, YYYY-MM, or YYYY-MM-DD.'], 400);


        }
    }

    public function showPatientCasesWithStudents($section)
    {
        $casesWithoutReferrals = PatientCases::join('patient', 'patient_cases.patient_id', '=', 'patient.id')
            ->join('student', 'patient_cases.student_id', '=', 'student.id')
            ->join('types_of_cases', 'patient_cases.types_of_cases_id', '=', 'types_of_cases.id')
            ->where('types_of_cases.section_id', $section) // إضافة شرط للـ section_id
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('referrals')
                    ->whereRaw('referrals.patient_cases_id = patient_cases.id');
            })
            ->select(
                'patient_cases.*',
                'patient.first_name as patient_first_name',
                'patient.last_name as patient_last_name',
                'patient.email as patient_email',
                'patient.gender as patient_gender',
                'patient.birthday as patient_birthday',
                'student.first_name as student_first_name',
                'student.last_name as student_last_name',
                'student.email as student_email',
                'student.year as student_year',
                'student.specialization as student_specialization',
                'types_of_cases.type as case_type'
            )
            ->get();

        return $casesWithoutReferrals;
    }

    public function showStudentsReferrals($section)
    {
        $referralsWithDetails = Referrals::join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->join('patient', 'patient_cases.patient_id', '=', 'patient.id')
            ->join('student', 'referrals.student_id', '=', 'student.id')
            ->select(
                'referrals.*',
                'patient_cases.details_of_cases',
                DB::raw('CONCAT(patient.first_name, " ", patient.last_name) as patient_full_name'),
                DB::raw('CONCAT(student.first_name, " ", student.last_name) as student_full_name')
            )
            ->get();

        return $referralsWithDetails;
    }

    public function showPatientTransferRequest($section)
    {
        $transferRequestsWithDetails = PatientTransferRequests::join('referrals', 'patient_transfer_requests.referrals_id', '=', 'referrals.id')
            ->join('patient_cases', 'referrals.patient_cases_id', '=', 'patient_cases.id')
            ->join('types_of_cases', 'patient_cases.types_of_cases_id', '=', 'types_of_cases.id')
            ->join('student', 'patient_transfer_requests.student_id', '=', 'student.id')
            ->join('patient', 'patient_cases.patient_id', '=', 'patient.id')
            ->where('types_of_cases.section_id', $section)
            ->select(
                'patient_transfer_requests.*',
                'referrals.*',
                'patient_cases.details_of_cases',
                DB::raw('CONCAT(patient.first_name, " ", patient.last_name) as patient_full_name'),
                DB::raw('CONCAT(student.first_name, " ", student.last_name) as student_full_name'),
                'types_of_cases.type as case_type'
            )
            ->get();

        return $transferRequestsWithDetails;
    }

    public function acceptTransferRequest($transfer_id)
    {
        $patient_transfer = PatientTransferRequests::find($transfer_id)->first();
        $referral_search = Referrals::find($patient_transfer->referrals_id)->first();
        $referral_search['student_id'] = $patient_transfer->student_id;
        $referral_search['type_of_refarrals'] = 'converted_from_student';
        $referral_search['status_of_refarrals'] = 'before_confirmation';
        $referral_search['status_done'] = 'not_finished';
        unset($referral_search->id);
        $new_referral = Referrals::create($referral_search->toArray());
        return $new_referral;
    }

    public function rejectTransferRequest($transfer_id)
    {
        $patient_transfer = PatientTransferRequests::find($transfer_id)->first()->delete();
        return $patient_transfer;
    }

    public function showSectionTypeOfCases($section)
    {
        $typesOfCases = TypesOfCases::join('sections', 'types_of_cases.section_id', '=', 'sections.id')
            ->where('sections.id', $section)
            ->select(
                'types_of_cases.*',
                'sections.name as section_name'
            )
            ->get();

        return $typesOfCases;
    }

    public function showClinicsInSection($section)
    {
        $clinics = Clinics::join('sections', 'clinics.section_id', '=', 'sections.id')
            ->where('sections.id', $section)
            ->select(
                'clinics.*',
                'sections.name as section_name'
            )
            ->get();
        return $clinics;
    }
    public function deleteTypeOfCases($type_id)
    {
        $type_of_cases=TypesOfCases::where(['id'=>$type_id,'section_id'=>auth()->id()])->first();
        if ($type_of_cases)
            $type_of_cases->delete();
        return $type_of_cases;
    }
    public function updateTypeOfCases($type_id,$type)
    {
        $type_of_cases=TypesOfCases::where(['id'=>$type_id,'section_id'=>auth()->id()])->first();
        if ($type_of_cases)
        {
            $type_of_cases->type=$type;
            $type_of_cases->save();
        }
        return $type_of_cases;
    }

}


