<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        $birthday = is_numeric($row['birthday']) ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthday'])) : $row['birthday'];
        return new Student([
            'first_name'       => $row['first_name'] ?? null,
            'last_name'        => $row['last_name'] ?? null,
            'gender'           => $row['gender'] ?? null,
            'birthday'         => $birthday ?? null,
            'year'             => $row['year'] ?? null,
            'specialization'   => $row['specialization'] ?? null,
            'university_number'=> $row['university_number'] ?? null,
            'diagnosis'        => isset($row['diagnosis']) ? (bool)$row['diagnosis'] : false, // تعيين القيمة الافتراضية
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}
