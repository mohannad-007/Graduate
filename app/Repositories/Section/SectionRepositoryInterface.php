<?php

namespace App\Repositories\Section;

interface SectionRepositoryInterface
{
    public function register(array $data);
    public function edit($id, array $data);
    public function delete($id);
    public function login(array $data);
    public function showPatientsInCurrentChapter($section,$chapter);
    public function getSections();
    public function addReferralToStudent($student_id,$patient_cases_id);
    public function addTypeOfCases( $type);
}
