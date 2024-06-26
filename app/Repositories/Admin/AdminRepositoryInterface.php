<?php

namespace App\Repositories\Admin;

interface AdminRepositoryInterface
{
    public function register(array $data);
    public function login(array $data);
    public function edit($id, array $data);
    public function getPatient();
    public function searchPatient($searchTerm);
    public function getClinic();
    public function getSpecificClinic($clinicID);
    public function deleteSpecificClinic($clinicID);
    public function updateSpecificClinic($clinicID,$number);
    public function createClinic($sectionID,$number);
    public function createStudentInfo($UN);
    public function updateStudentInfo($UN,$id);
    public function viewAllStudentInfo();
    public function viewSpecificStudentInfo($id);
    public function deleteSpecificStudentInfo($id);
    public function giveRuleDiagnosisToStudent($id);
    public function getAllSections();
    public function deleteSpecificSections($id);
    public function getProfileSections();
    public function getProfileSupervisor();
    public function getProfileDiagnosis();
}
