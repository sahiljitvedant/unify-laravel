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
        Schema::table('tbl_policy', function (Blueprint $table) {
            // Change the 'description' column to LONGTEXT
            $table->longText('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_policy', function (Blueprint $table) {
            // Change it back to TEXT in case of rollback
            $table->text('description')->change();
        });
    }
};
