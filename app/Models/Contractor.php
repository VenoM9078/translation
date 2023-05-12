<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function contractorOrders()
    {
        return $this->hasMany('App\Models\ContractorOrder', 'contractor_id');
    }

    public function proofReadOrders(){
        return $this->hasMany('App\Models\ProofReaderOrders', 'contractor_id');
    }
}
