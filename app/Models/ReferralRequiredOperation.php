<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralRequiredOperation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function referrals()
    {
        return $this->belongsTo(Referrals::class);
    }
    public function requiredOperations()
    {
        return $this->belongsTo(RequiredOperations::class);
    }
}
