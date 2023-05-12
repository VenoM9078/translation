<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorInterpretation extends Model
{
    use HasFactory;

    protected $table = 'contractor_interpretations';

    protected $fillable = [
        'contractor_id',
        'interpretation_id',
        'is_accepted',
        'dateDecided',
        'description',
        'amount',
        'start_time_decided',
        'end_time_decided'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }

    public function interpretation()
    {
        return $this->belongsTo('App\Models\Interpretation', 'interpretation_id');
    }
}
