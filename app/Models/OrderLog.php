<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'user_type', 'action', 'old_translation_status', 'new_translation_status', 'old_payment_status', 'new_payment_status', 'old_translation_sent_status', 'new_translation_sent_status', 'old_proofread_sent_status', 'new_proofread_sent_status', 'old_order_completed_status', 'new_order_completed_status', 'is_admin'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'user_id')->withDefault();
    }

}