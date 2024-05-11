<?php

namespace App\Repositories\Patient;

interface PatientRepositoryInterface
{
    public function register(array $data);
    public function login(array $data);
    public function create($id,array $data);
    public function showProfileInfo();
    public function showPatientCaseByPatientId($patient_id);
    public function patientSessionRelatedWithStudent($patient_id,$student_id);
//    public function bookAppointment($patient_id,$reason);
    public function bookAppointment($data);
    public function viseted($patient_id);
    public function archiveVisited($patient_id);
    public function myAppointment($patient_id);
    public function archiveMyAppointment($patient_id);
    public function toolsRequired($patient_id);
    public function viewDiseases();
    public function viewHealthRecord();

}
