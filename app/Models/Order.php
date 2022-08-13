<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Invoice;
use App\Models\TranslationRequest;
use App\Models\ProofRequest;
use App\Models\CompletedRequest;



class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worknumber',
        'language1',
        'language2',
        'access_code',
        'casemanager',
        'paymentStatus',
        'invoiceSent',
        'is_evidence',
        'filename',
        'evidence_accepted',
        'amount',
        'orderStatus',
        'translation_status',
        'proofread_status',
        'completed'
    ];

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

    public function completedRequest() {
        return $this->hasOne('App\Models\CompletedRequest', 'order_id','id');
    }
}
