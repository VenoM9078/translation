<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interpretation extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'interpretationDate',
        'start_time',
        'end_time',
        'worknumber',
        'session_format',
        'location',
        'session_topics',
        'wantQuote',
        'quote_price',
        'quote_description',
        'invoiceSent',
        'paymentStatus',
        'interpreter_id',
        'interpreter_completed',
        'feedback',
        'added_by_institute_user'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function interpreter()
    {
        return $this->belongsTo('App\Models\Contractor', 'interpreter_id');
    }

    public function contractorInterpretation()
    {
        return $this->hasOne('App\Models\ContractorInterpretation', 'interpretation_id');
        // public function order(){
    }

    // }
    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }
}
