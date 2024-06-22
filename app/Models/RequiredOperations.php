<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredOperations extends Model
{
    use HasFactory;
    protected $fillable=['chapter','date','number_of_cases','student_id','types_of_cases_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function typesOfCases()
    {
        return $this->belongsTo(TypesOfCases::class);
    }
    public function referralRequiredOperation()
    {
        return $this->hasMany(ReferralRequiredOperation::class);
    }


}
