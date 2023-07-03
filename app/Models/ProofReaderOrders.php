<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofReaderOrders extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'contractor_id',
        'is_accepted',
        'rate',
        'total_payment',
        'status',
        'contractor_order_id',
        'translation_status',
        'feedback',
        'proofread_type',
        'proof_read_due_date',
        'proof_read_paid',
        'proof_read_adjust_note',
        'p_unit',
        'p_adjust',
        'message',
        'file_uploaded_by_admin',
        'added_by_admin'
    ];

    public function contractor()
    {
        return $this->belongsTo('App\Models\Contractor', 'contractor_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    public function contractorOrder()
    {
        return $this->belongsTo('App\Models\ContractorOrder', 'contractor_order_id');
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
            'contractorOrder' => 'App\Models\ContractorOrder'
        ];

        foreach ($relationships as $relationship => $model) {
            $emptyModel->{$relationship} = new $model();
        }
        return $emptyModel;
    }
}