<?php

namespace App\Repositories\Student;

interface StudentRepositoryInterface
{
    public function register($unNumber,array $data);
    public function login(array $data);
    public function edit($id,array $data);
    public function sectionsView();
    public function getClinicsBySectionId($id);
    public function convertFromSection();
    public function convertFromStudent();
    public function studentViewCases();
    public function studentSendCases($studentId,$patientCasesId,$note);
    public function studentDiagnosisCases();
    public function studentPatientHealthRecord($patientId);
    public function studentPatientToolsRequired($patientId,$sessionId);
    public function studentPatientSessions($patientId);
    public function studentAppointments($history);
    public function studentProfileView();
    public function studentPatientNow();
    public function addTools($details_of_tool,$image_tool);
    public function getTools();
    public function destroyTools($id);
    public function addSession(array $data);
    public function updateSession(array $data);
    public function tupeOfSections();
    public function viewDisease();
    public function allStudentView();
    public function viewMyReferrals();
    public function acceptMyReferral($referral_id);
    public function rejectMyReferral($referral_id);

}
