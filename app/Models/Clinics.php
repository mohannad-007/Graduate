<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{
    use HasFactory;
    protected $fillable=['number','section_id'];

    public function sections()
    {
        return $this->belongsTo(Sections::class,'section_id');
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
