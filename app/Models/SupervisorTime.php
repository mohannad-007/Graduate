<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorTime extends Model
{
    use HasFactory;
    protected $fillable=['clinic_id','supervisor_id','end_time','start_time','day'];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
    public function clinics()
    {
        return $this->belongsTo(Clinics::class);
    }
}
