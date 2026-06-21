<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kita tambahkan kolom-kolom yang belum ada (gunakan jika belum didefinisikan)
            if (!Schema::hasColumn('transactions', 'property_price')) {
                $table->bigInteger('property_price')->default(0)->after('property_id');
            }
            if (!Schema::hasColumn('transactions', 'tax_amount')) {
                $table->bigInteger('tax_amount')->default(0)->after('property_price');
            }
            if (!Schema::hasColumn('transactions', 'gross_amount')) {
                $table->bigInteger('gross_amount')->default(0)->after('tax_amount');
            }
            if (!Schema::hasColumn('transactions', 'total_payable')) {
                $table->bigInteger('total_payable')->default(0)->after('gross_amount');
            }
            if (!Schema::hasColumn('transactions', 'amount_paid')) {
                $table->bigInteger('amount_paid')->default(0)->after('total_payable');
            }
            if (!Schema::hasColumn('transactions', 'admin_fee')) {
                $table->integer('admin_fee')->default(0)->after('amount_paid');
            }
            if (!Schema::hasColumn('transactions', 'payment_type')) {
                $table->string('payment_type')->default('cash')->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'property_price', 'tax_amount', 'gross_amount',
                'total_payable', 'amount_paid', 'admin_fee', 'payment_type'
            ]);
        });
    }
};
