<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_examination', 'details'];

    public function patientExaminations()
    {
        return $this->hasMany(PatientExaminations::class);
    }
}
