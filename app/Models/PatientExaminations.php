<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientExaminations extends Model
{
    use HasFactory;
    protected $fillable =['patient_id', 'examinations_id','image','details'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
