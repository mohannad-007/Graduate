<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLaboratoryTools extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function laboratoryToolsRequired()
    {
        return $this->hasMany(LaboratoryToolsRequired::class);
    }

}
