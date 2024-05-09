<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Diagnosis extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
//    protected $fillable = [
//        'first_name',
//        'last_name',
//        'email',
//        'password',
//        'gender',
//        'created_at',
//        'updated_at',
//    ];
    protected $guarded = [];

    public function diagnosisAppointments()
    {
        return $this->hasMany(DiagnosisAppointments::class);
    }

}
