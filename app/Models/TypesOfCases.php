<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesOfCases extends Model
{
    use HasFactory;
    protected $fillable=['type','section_id'];

    public function sections()
    {
        return $this->belongsTo(Sections::class,'section_id');
    }

    public function requiredOperations()
    {
        return $this->hasMany(RequiredOperations::class);
    }

    public function patientCases()
    {
        return $this->hasMany(PatientCases::class);
    }
}
