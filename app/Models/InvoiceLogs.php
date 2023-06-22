<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_type',
        'action',
        'model_name',
        'is_admin',
        'interpretation_id',
        'order_id',

        'invoice_sent'
    ];
}