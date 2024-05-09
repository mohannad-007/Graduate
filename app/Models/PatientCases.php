<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCases extends Model
{
    use HasFactory;
    protected $fillable= [
        'details_of_cases',
        'diagnosis_appointments_id',
        'patient_id',
        'student_id',
        'types_of_cases_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function typesOfCases()
    {
        return $this->belongsTo(TypesOfCases::class);
    }

    public function diagnosisAppointments()
    {
        return $this->belongsTo(DiagnosisAppointments::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referrals::class);
    }


}
