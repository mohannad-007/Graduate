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
}
