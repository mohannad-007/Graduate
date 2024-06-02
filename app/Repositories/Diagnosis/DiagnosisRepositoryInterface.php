<?php

namespace App\Repositories\Diagnosis;

interface DiagnosisRepositoryInterface
{
    public function register(array $data);
    public function edit($id,array $data);
    public function  delete($id);
    public function login(array $data);
    public function pendingPatientView();
    public function acceptPatientView();
    public function currentPatientView();
    public function acceptPatientAppointment(array $data);
    public function studentView();
    public function studentTrueDiagnosisView();
    public function studentGiveRules($studentIds);

}
