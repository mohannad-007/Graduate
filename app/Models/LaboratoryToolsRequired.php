<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryToolsRequired extends Model
{
    use HasFactory;
    protected $guarded=[];
     protected $table = 'laboratory_tools_required';

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
    public function studentLaboratoryTools()
    {
        return $this->belongsTo(StudentLaboratoryTools::class,'laboratoryTools_id');
    }
}
