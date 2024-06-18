<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Supervisor extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'first_name',
        'email',
        'password',
        'last_name',
        'gender',
        'student_id',
        'type',
        'created_at',
        'updated_at',
    ];

    protected  $hidden =['created_at','updated_at','password','remember_token'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisorTime()
    {
        return $this->hasMany(SupervisorTime::class);
    }

    public function sessions()
    {
        return $this->hasMany(Sessions::class);
    }
    public function clinics()
    {
        return $this->hasManyThrough(
            Clinics::class,
            SupervisorTime::class,
            'supervisor_id', // Foreign key on SupervisorTime table...
            'id',            // Foreign key on Clinics table...
            'id',            // Local key on Supervisors table...
            'clinic_id'      // Local key on SupervisorTime table...
        );
    }

    public function sections()
    {
        return $this->hasManyThrough(
            Sections::class,
            Clinics::class,
            'id',            // Foreign key on Clinics table...
            'section_id',    // Foreign key on Sections table...
            'id',            // Local key on Supervisors table...
            'id'             // Local key on Clinics table...
        )->distinct();
    }
}
