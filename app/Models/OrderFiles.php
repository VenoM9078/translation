<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFiles extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'filename'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
