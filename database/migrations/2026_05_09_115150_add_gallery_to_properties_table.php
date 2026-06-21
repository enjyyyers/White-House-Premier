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
    Schema::table('properties', function (Blueprint $table) {
        // Jangan pakai ->after() dulu kalau kolom tujuannya belum ada/sedang dibuat
        $table->string('image_living_room')->nullable();
        $table->string('image_bathroom')->nullable();
        $table->string('image_exterior')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['image_living_room', 'image_bathroom', 'image_exterior']);
        });
    }
};
