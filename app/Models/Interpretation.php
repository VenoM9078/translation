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
        'added_by_institute_user',
        'message',
        'quote_filename',
        'is_quote_pending',
        'c_type',
        'c_unit',
        'c_rate',
        'c_adjust',
        'c_fee',
        'c_adjust_note',
        'c_paid',
        'interpreter_adjust_note',
        'interpreter_paid',
        'is_reminder_on',
        'reminder_email_sent'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function interpreter()
    {
        return $this->belongsTo('App\Models\Contractor', 'interpreter_id');
    }

    public function quote(){
        return $this->quote_description;
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

    public function invoiceLogs()
    {
        return $this->hasMany('App\Models\InvoiceLogs', 'interpretation_id', 'id');
    }
    public function contractorLogs()
    {
        return $this->hasMany('App\Models\ContractorLog', 'interpretation_id', 'id');
    }

    public function interpretationLogs()
    {
        return $this->hasMany('App\Models\OrderLog', 'interpretation_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($interpretation) {
            // Define relationships
            $relationships = [
                'interpretationLogs',
                'contractorLogs',
                'invoiceLogs',
                'contractorInterpretation',                
            ];

            // Iterate over relationships and delete
            foreach ($relationships as $relationship) {
                // It's good practice to check if the relationship exists before trying to delete it
                if ($interpretation->$relationship()) {
                    $interpretation->$relationship()->delete();
                }
            }
        });
    }
}
