<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $table = 'student';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'birthday',
        'year',
        'specialization',
        'diagnosis',
        'university_number',
        'created_at',
        'updated_at',
    ];

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicines::class);
    }

    public function laboratoryToolsRequired()
    {
        return $this->hasMany(LaboratoryToolsRequired::class);
    }

    public function requiredOperations()
    {
        return $this->hasMany(RequiredOperations::class);
    }

    public function supervisor()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function patientCases()
    {
        return $this->hasMany(PatientCases::class);
    }
    public function referrals()
    {
        return $this->hasMany(Referrals::class);
    }

    public function patientTransferRequests()
    {
        return $this->hasMany(PatientTransferRequests::class);
    }

    public function diagnosisAppointments()
    {
        return $this->hasMany(DiagnosisAppointments::class);
    }



}
