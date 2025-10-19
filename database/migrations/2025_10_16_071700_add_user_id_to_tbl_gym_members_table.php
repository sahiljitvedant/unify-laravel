<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            // Add user_id column after id (you can adjust position)
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // Optional: if you want foreign key relation with tbl_users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('tbl_users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
