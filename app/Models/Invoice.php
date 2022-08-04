<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Notifications\Notifiable;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'description', 'docQuantity', 'amount'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
