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
                $table->decimal('property_price', 15, 2)->default(0)->after('property_id');
            }
            if (!Schema::hasColumn('transactions', 'tax_amount')) {
                $table->decimal('tax_amount', 15, 2)->default(0)->after('property_price');
            }
            if (!Schema::hasColumn('transactions', 'gross_amount')) {
                $table->decimal('gross_amount', 15, 2)->default(0)->after('tax_amount');
            }
            if (!Schema::hasColumn('transactions', 'total_payable')) {
                $table->decimal('total_payable', 15, 2)->default(0)->after('gross_amount');
            }
            if (!Schema::hasColumn('transactions', 'amount_paid')) {
                $table->decimal('amount_paid', 15, 2)->default(0)->after('total_payable');
            }
            if (!Schema::hasColumn('transactions', 'admin_fee')) {
                $table->decimal('admin_fee', 15, 2)->default(0)->after('amount_paid');
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
