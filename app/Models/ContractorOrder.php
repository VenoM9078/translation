<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorOrder extends Model
{
    use HasFactory;
    protected $table = 'contractor_orders';

    protected $fillable = [
        'order_id',
        'contractor_id',
        'is_accepted',
        'rate',
        'total_payment',
        'total_words',
        'message',
        'translation_due_date',
        'translation_type',
        'translator_adjust_note'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function proofReadOrder()
    {
        return $this->hasOne('App\Models\ProofReaderOrders', 'id');
    }
}