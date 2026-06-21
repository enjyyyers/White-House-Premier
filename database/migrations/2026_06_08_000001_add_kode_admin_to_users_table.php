<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kode_admin')->unique()->nullable()->after('role');
            $table->enum('jenis_kelamin', ['P', 'L'])->nullable()->after('kode_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kode_admin', 'jenis_kelamin']);
        });
    }
};
