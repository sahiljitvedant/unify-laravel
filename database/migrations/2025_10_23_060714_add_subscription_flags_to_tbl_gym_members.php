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
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->enum('manual_payment_flag', ['0', '1'])
                  ->default('0')
                  ->after('profile_image'); // replace with the column after which you want this
            
            $table->enum('cron_flag', ['0', '1'])
                  ->default('0')
                  ->after('manual_payment_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->dropColumn(['manual_payment_flag', 'cron_flag']);
        });
    }
};
