<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = [
        'user_id',
        'property_id',
        'transaction_code',
        'property_price',
        'tax_amount',
        'gross_amount',
        'total_payable',
        'amount_paid',
        'admin_fee',
        'payment_status',
        'payment_type',
        'installment_plan',
        'installment_period_months',
        'installment_count',
        'service_fee',
        'installment_total',
        'paid_installments',
    ];

    protected $casts = [
        'property_price' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'gross_amount' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'installment_total' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function property() {
        return $this->belongsTo(Property::class);
    }

    public function installments() {
        return $this->hasMany(Installment::class);
    }

    public function getIsInstallmentAttribute() {
        $plan = $this->installment_plan;
        return $plan !== null && $plan !== 'none';
    }

    public function getInstallmentProgressAttribute() {
        if ($this->installment_count <= 0) return 0;
        return round(($this->paid_installments / $this->installment_count) * 100, 1);
    }

    public function getNextDueInstallmentAttribute() {
        if (!$this->is_installment) return null;
        return $this->installments()
            ->where('payment_status', 'pending')
            ->oldest('due_date')
            ->first();
    }
}
