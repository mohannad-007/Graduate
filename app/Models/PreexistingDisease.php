<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreexistingDisease extends Model
{
    use HasFactory;

    protected $fillable = ['type_of_disease', 'details'];

    public function patientDiseases()
    {
        return $this->hasMany(PatientDisease::class);
    }
}
