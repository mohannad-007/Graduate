<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContinuousMedication extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_medicine', 'details'];

    public function patientMedications()
    {
        return $this->hasMany(PatientMedication::class);
    }
}
