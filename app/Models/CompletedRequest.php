<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'email',
        'completed_file',
        'translation_id',
        'proofreader_id'
    ];

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function translationRequest() {
        return $this->belongsTo('App\Models\TranslationRequest', 'translation_id','id');
    }

    public function proofReaderRequest() {
        return $this->belongsTo('App\Models\ProofRequest', 'proofreader_id','id');
    }
}
