<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosisAppointments extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['reason','date','order_status','patient_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function patientCases()
    {
        return $this->hasMany(PatientCases::class);
    }
}
