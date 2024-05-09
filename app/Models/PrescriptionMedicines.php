<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicines extends Model
{
    use HasFactory;
    protected $fillable=['patient_id', 'student_id', 'description_details'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
