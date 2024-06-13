<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    use HasFactory;
//    protected $fillable=[
//        'status_done',
//        'status_of_refarrals',
//        'patient_cases_id',
//        'student_id',
//        'type_of_refarrals',
//    ];
    protected $guarded=[];

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
}
