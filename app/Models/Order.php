<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Invoice;
use App\Models\TranslationRequest;
use App\Models\ProofRequest;



class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'worknumber', 'language1', 'language2', 'casemanager', 'paymentStatus', 'invoiceSent', 'amount', 'orderStatus'];

    public function files()
    {
        return $this->hasMany('App\Models\OrderFiles');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice', 'order_id', 'id');
    }

    public function translationRequest()
    {
        return $this->hasOne('App\Models\TranslationRequest', 'order_id', 'id');
    }

    public function proofReadRequest() {
        return $this->hasOne('App\Models\ProofRequest', 'order_id','id');
    }
}
