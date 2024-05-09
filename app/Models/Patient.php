<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $table = 'patient';

    protected $fillable = [
        'first_name',
        'email',
        'password',
        'last_name',
        'gender',
        'birthday',
        'remember_token',
        'created_at',
        'updated_at',
        'image'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'last_name' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function patientMedications()
    {
        return $this->hasMany(PatientMedication::class);
    }

    public function patientDiseases()
    {
        return $this->hasMany(PatientDisease::class);
    }
    public function patientExaminations()
    {
        return $this->hasMany(PatientExaminations::class);
    }

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicines::class);
    }
    public function laboratoryToolsRequired()
    {
        return $this->hasMany(LaboratoryToolsRequired::class);
    }
    public function diagnosisAppointments()
    {
        return $this->hasMany(DiagnosisAppointments::class);
    }
    public function patientCases()
    {
        return $this->hasMany(PatientCases::class);
    }

    public function radiographs()
    {
        return $this->hasMany(Radiographs::class);
    }
    public function patientHealthRecords()
    {
        return $this->hasMany(PatientHealthRecords::class);
    }


}
