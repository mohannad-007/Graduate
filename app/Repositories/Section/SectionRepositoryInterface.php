<?php

namespace App\Repositories\Section;

interface SectionRepositoryInterface
{
    public function register(array $data);
    public function edit($id, array $data);
    public function delete($id);
    public function login(array $data);
}
