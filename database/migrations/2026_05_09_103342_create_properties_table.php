<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: The Grand Residence
        $table->string('slug')->unique(); // Untuk URL: the-grand-residence
        $table->string('category'); // Contoh: Rumah Mewah
        $table->string('location'); // Contoh: Menteng, Jakarta Pusat
        $table->bigInteger('price'); // Harga dasar: 5500000000

        // Data Fasilitas (Sesuai image_079639.png)
        $table->integer('bedrooms'); // 5
        $table->integer('bathrooms'); // 4
        $table->integer('building_area'); // 450 m2
        $table->integer('land_area'); // 600 m2

        // Rincian Biaya (Sesuai rincian pembayaran di image_079639.png)
        $table->bigInteger('ipl_cost')->default(0);
        $table->bigInteger('tax_cost')->default(0);
        $table->bigInteger('admin_cost')->default(10000000);

        $table->text('description');
        $table->string('image')->nullable(); // Path foto utama
        $table->string('google_maps_url')->nullable();
        $table->enum('status', ['available', 'sold', 'booked'])->default('available');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
