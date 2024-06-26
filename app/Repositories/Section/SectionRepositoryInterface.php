<?php

namespace App\Repositories\Section;

interface SectionRepositoryInterface
{
    public function register(array $data);
    public function edit($id, array $data);
    public function delete($id);
    public function login(array $data);
    public function getSections();
    public function addReferralToStudent($student_id,$patient_cases_id);
    public function addTypeOfCases($type);
    public function  addSuperVisorTimeToClinic(array $data);
    public function showPatientsInCurrentChapter($section,$chapter);
    public function showCasesInCurrentChapter($section,$chapter);
    public function showArchiveCasesDate($section,$dateInput);
    public function showPatientCasesWithStudents($section);
    public function showStudentsReferrals($section);
    public function showPatientTransferRequest($section);
    public function acceptTransferRequest($transfer_id);
    public function rejectTransferRequest($transfer_id);
    public function showSectionTypeOfCases($section);
    public function showClinicsInSection($section);
    public function deleteTypeOfCases($type_id);
    public function updateTypeOfCases($type_id,$type);


}
