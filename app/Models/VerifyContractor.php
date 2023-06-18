<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyContractor extends Model
{
    use HasFactory;
    protected $fillable = [
        'contractor_id',
        'token',
        'expiry_time'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }
}