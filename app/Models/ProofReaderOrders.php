<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofReaderOrders extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'contractor_id',
        'is_accepted',
        'rate',
        'total_payment',
        'status',
        'contractor_order_id',
        'translation_status',
        'feedback',
        'proofread_type',
        'proof_read_due_date'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    public function contractorOrder()
    {
        return $this->belongsTo('App\Models\ContractorOrder', 'contractor_order_id');
    }
}