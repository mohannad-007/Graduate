<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiographs extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $fillable = ['patient_id', 'radiograph_image'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
