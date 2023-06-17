<?php

namespace App\Models;

use App\Notifications\ContractorVerifyEmail;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contractor extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phonenumber',
        'address',
        'SSN',
        'interpretation_rate',
        'translation_rate',
        'proofreader_rate',
        'verified',
        'education_1',
        'education_2',
        'education_3',
        'years_of_experience',
        'certification',
        'interpreter_adjust_note',
        'interpreter_paid'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contractorOrders()
    {
        return $this->hasMany('App\Models\ContractorOrder', 'contractor_id');
    }

    public function proofReadOrders()
    {
        return $this->hasMany('App\Models\ProofReaderOrders', 'contractor_id');
    }

    public function languages()
    {
        return $this->hasMany(ContractorLanguage::class);
    }

    public function proofReadRequest()
    {
        return $this->hasOne('App\Models\ProofRequest', 'contractor_id', 'id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new ContractorVerifyEmail); // assuming you have a ContractorVerifyEmail notification
    }

    public function verifyContractor()
    {
        return $this->hasOne('App\Models\VerifyContractor');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}