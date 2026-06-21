<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_code')->unique(); // TR-WH-2026001
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('property_id')->constrained()->onDelete('cascade');

        // Jenis Pembayaran
        $table->enum('payment_type', ['booking', 'dp', 'cash', 'kpr']);

        // Detail Biaya (Decimal 15,2 mendukung hingga Triliun)
        $table->decimal('property_price', 15, 2);
        $table->decimal('tax_amount', 15, 2);      // PPN
        $table->decimal('admin_fee', 15, 2);      // Notaris & Admin
        $table->decimal('total_payable', 15, 2);  // Total harga + biaya
        $table->decimal('amount_paid', 15, 2);    // Nominal yang dibayar saat ini (misal 10jt buat booking)

        // Status & Midtrans
        $table->string('payment_status')->default('pending'); // pending, success, failed, expired
        $table->string('snap_token')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
