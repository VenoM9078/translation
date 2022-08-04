<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class TranslationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'translator_email',
        'email_title',
        'email_body',
        'translation_status'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
