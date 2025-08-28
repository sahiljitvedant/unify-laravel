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
        Schema::table('tbl_gym_membership', function (Blueprint $table) {
            $table->tinyInteger('is_deleted')
                  ->default(1)
                  ->after('is_active')
                  ->comment('1 = Not Deleted, 9 = Deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_gym_membership', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
};
