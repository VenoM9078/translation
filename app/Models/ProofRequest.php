<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class ProofRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'proofreader_email',
        'email_title',
        'email_body',
        'proofread_status',
        'translated_files'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
