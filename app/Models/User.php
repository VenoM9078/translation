<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable

implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'failed_inst_user',
        'invalid_passcode_inst_user',
        'is_inst_message_seen'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function interpretations()
    {
        return $this->hasMany('App\Models\Interpretation');
    }


    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function institute_managed()
    {
        return $this->hasOne('App\Models\Institute', 'managed_by');
    }

    public function institute()
    {
        return $this->belongsToMany('App\Models\Institute', 'institute_members')->withTimestamps();
    }

    public function user_requests()
    {
        return $this->hasMany('App\Models\InstituteUserRequests', 'user_id');
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            \DB::transaction(function () use ($user) {
                $user->orders()->delete();
                $user->interpretations()->delete();
            });
        });
    }
}
