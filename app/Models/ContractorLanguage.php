<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'language',
        'is_translator',
        'is_interpreter',
        'is_proofreader'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
