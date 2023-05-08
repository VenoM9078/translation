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
        'description',
        'amount'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}