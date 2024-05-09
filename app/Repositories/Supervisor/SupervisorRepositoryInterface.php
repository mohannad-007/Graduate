<?php

namespace App\Repositories\Supervisor;

interface SupervisorRepositoryInterface
{
    public function register(array $data);
    public function  delete($id);
    public function edit($id,array $data);
    public function login(array $data);
}
