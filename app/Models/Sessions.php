<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use HasFactory;
    protected $fillable=[
        'referrals_id',
        'clinic_id',
        'supervisor_id',
        'supervisor_notes',
       'supervisor_evaluation',
        'student_notes',
        'history',
        'status_of_session',
    ];

    public function referrals()
    {
        return $this->belongsTo(Referrals::class);
    }

    public function clinics()
    {
        return $this->belongsTo(Clinics::class,'clinic_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function laboratoryToolsRequired()
    {
        return $this->hasMany(LaboratoryToolsRequired::class);
    }
}
