<?php

namespace App\Repositories\Supervisor;

interface SupervisorRepositoryInterface
{
    public function register(array $data);
    public function  delete($id);
    public function edit($id,array $data);
    public function login(array $data);
    public function getClinic();
    public function getSessions();
    public function sessionDetails($session_id);
    public function addSessionNotes($session_id,$notes,$evaluation);
    public function studentInClinics();
    public function studentPatient($clinic_id);
    public function patientRelatedWithSessions($patient_id);
}
