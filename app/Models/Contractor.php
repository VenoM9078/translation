<?php

namespace App\Models;

use App\Notifications\ContractorVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contractor extends Authenticatable

implements MustVerifyEmail
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
        'proofreader_rate'
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
}
