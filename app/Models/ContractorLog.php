<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorLog extends Model
{
    use HasFactory;
       protected $fillable = [
        'order_id', 
        'user_id', 
        'contractor_id', 
        'user_type', 
        'contractor_type', 
        'old_translation_status', 
        'new_translation_status', 
        'is_accepted', 
        'action', 
        'model_name',
        'is_admin',
        'old_proof_read_sent_status',
        'new_proof_read_sent_status',
        'new_interpretation_sent_status',
        'old_interpretation_sent_status'
    ];

    public function admin(){
        return $this->belongsTo('App\Models\Admin','user_id','id');
    }
}
