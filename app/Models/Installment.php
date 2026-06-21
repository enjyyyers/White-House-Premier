<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'transaction_id',
        'installment_number',
        'amount',
        'paid_amount',
        'due_date',
        'payment_status',
        'snap_token',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getIsPaidAttribute()
    {
        return $this->payment_status === 'success';
    }

    public function getRemainingAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
}
