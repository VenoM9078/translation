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
        'is_active',
        'member_approval_needed'
    ];

    public function admin()
    {
        return $this->hasOne('App\Models\User', 'id', 'managed_by');
    }

    public function manager()
    {
        return $this->belongsTo('App\Models\User', 'managed_by');
    }

    public function members()
    {
        return $this->belongsToMany('App\Models\User', 'institute_members', 'institute_id', 'user_id');
    }


    public function requests()
    {
        return $this->hasMany('App\Models\InstituteUserRequests', 'institute_id');
    }
}
