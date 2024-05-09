<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Sections extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $guarded = [];
//    protected $fillable=['name','details','email','password'];

    public function clinics()
    {
        return $this->hasMany(Clinics::class);
    }

    public function typesOfCases()
    {
        return $this->hasMany(TypesOfCases::class);
    }
    public function responsibleSections()
    {
        return $this->hasMany(ResponsibleSections::class);
    }
}
