<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryToolsRequired extends Model
{
    use HasFactory;
    protected $fillable= ['image_tool','details_of_tool','student_id','patient_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function sessions()
    {
        return $this->belongsTo(Sessions::class,'session_id');
    }
}
