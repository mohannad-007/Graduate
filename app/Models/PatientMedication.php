<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientMedication extends Model
{
    use HasFactory;
    protected $guarded=[];
//    protected $fillable = ['patient_id', 'name'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function continuousMedication()
    {
        return $this->belongsTo(ContinuousMedication::class);
    }
}
