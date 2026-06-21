<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'installment_plan')) {
                $table->enum('installment_plan', ['none', 'monthly', 'quarterly', 'semi_annually'])
                    ->default('none')->after('payment_type');
            }
            if (!Schema::hasColumn('transactions', 'installment_period_months')) {
                $table->integer('installment_period_months')->default(1)->after('installment_plan');
            }
            if (!Schema::hasColumn('transactions', 'installment_count')) {
                $table->integer('installment_count')->default(1)->after('installment_period_months');
            }
            if (!Schema::hasColumn('transactions', 'service_fee')) {
                $table->decimal('service_fee', 15, 2)->default(0)->after('installment_count');
            }
            if (!Schema::hasColumn('transactions', 'installment_total')) {
                $table->decimal('installment_total', 15, 2)->default(0)->after('service_fee');
            }
            if (!Schema::hasColumn('transactions', 'paid_installments')) {
                $table->integer('paid_installments')->default(0)->after('installment_total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'installment_plan',
                'installment_period_months',
                'installment_count',
                'service_fee',
                'installment_total',
                'paid_installments',
            ]);
        });
    }
};
