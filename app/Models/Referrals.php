<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    use HasFactory;

    protected $guarded=[];
protected  $hidden = ['created_at','updated_at'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function patientCases()
    {
        return $this->belongsTo(PatientCases::class,'patient_cases_id');
    }

    public function patientTransferRequests()
    {
        return $this->hasMany(PatientTransferRequests::class);
    }

    public function sessions()
    {
        return $this->hasMany(Sessions::class);
    }
    public function referralRequiredOperation()
    {
        return $this->hasMany(ReferralRequiredOperation::class);
    }
    public function requiredOperations()
    {
        return $this->belongsToMany(RequiredOperations::class, 'referral_required_operations')
            ->withPivot('date')
            ->withTimestamps();
    }
}
