<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'managed_by',
        'passcode',
        'is_active'
    ];

    public function admin()
    {
        return $this->hasOne('App\Models\User', 'id', 'managed_by');
    }
    public function members()
    {
        return $this->belongsToMany('App\Models\InstituteMembers', 'institute_id', 'id');
    }
}