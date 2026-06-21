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
            // Add foreign key columns
            if (!Schema::hasColumn('properties', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('slug');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            }

            if (!Schema::hasColumn('properties', 'type_id')) {
                $table->unsignedBigInteger('type_id')->nullable()->after('category_id');
                $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Drop foreign keys
            if (Schema::hasColumn('properties', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            if (Schema::hasColumn('properties', 'type_id')) {
                $table->dropForeign(['type_id']);
                $table->dropColumn('type_id');
            }
        });
    }
};
