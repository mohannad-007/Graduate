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
}
