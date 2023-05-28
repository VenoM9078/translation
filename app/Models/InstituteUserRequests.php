<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteUserRequests extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'institute_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function institute()
    {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }
}
