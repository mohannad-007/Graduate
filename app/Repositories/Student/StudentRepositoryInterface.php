<?php

namespace App\Repositories\Student;

interface StudentRepositoryInterface
{
    public function register($unNumber,array $data);
    public function login(array $data);
    public function edit($id,array $data);
    public function sectionsView();
    public function convertFromSection();
    public function convertFromStudent();
    public function studentViewCases($typeId);
    public function studentSendCases($studentId,$patientCasesId,$note);
    public function studentDiagnosisCases();
    public function studentPatientHealthRecord($patientId);
}
