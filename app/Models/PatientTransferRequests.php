<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTransferRequests extends Model
{
    use HasFactory;
    protected $fillable=['note','referrals_id','student_id'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function referrals()
    {
        return $this->belongsTo(Referrals::class);
    }
}
