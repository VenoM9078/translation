<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorOrder extends Model
{
    use HasFactory;
    protected $table = 'contractor_orders';

    protected $fillable = [
        'order_id',
        'contractor_id',
        'is_accepted',
        'rate',
        'total_payment',
        'total_words',
        'message',
        'translation_due_date',
        'translation_type',
        'translator_adjust_note',
        'translator_adjust',
        'translator_unit',
        'translator_paid',
        'added_by_admin',
        'file_name'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id')->withDefault();
    }

    public function proofReadOrder()
    {
        return $this->hasOne('App\Models\ProofReaderOrders', 'id');
    }

    protected static function booted()
    {
        static::deleting(function ($contractorOrder) {
            if ($contractorOrder->proofReadOrder) {
                $contractorOrder->proofReadOrder()->delete();
            }
        });
    }

    public static function emptyModel()
    {
        $emptyModel = new self();

        foreach ($emptyModel->getAttributes() as $key => $value) {
            $emptyModel->{$key} = '';
        }
        $relationships = [
            'contractor' => 'App\Models\Contractor',
            'order' => 'App\Models\Order',
            'proofReadOrder' => 'App\Models\ProofReaderOrders',
        ];

        foreach ($relationships as $relationship => $model) {
            $emptyModel->{$relationship} = new $model();
        }
        foreach ($relationships as $relationship => $model) {
            $emptyModel->{$relationship} = new $model();
        }
        return $emptyModel;
    }
}