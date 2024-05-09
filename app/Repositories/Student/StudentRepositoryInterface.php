<?php

namespace App\Repositories\Student;

interface StudentRepositoryInterface
{
    public function register($unNumber,array $data);
    public function login(array $data);
    public function edit($id,array $data);
    public function sectionsView();
}
