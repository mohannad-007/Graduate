<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientDisease extends Model
{
    use HasFactory;

//    protected $fillable = ['patient_id', 'preexisting_disease_id', 'details'];
    protected $guarded=[];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function preexistingDisease()
    {
        return $this->belongsTo(PreexistingDisease::class);
    }
}
