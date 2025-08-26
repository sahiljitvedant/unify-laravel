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
            // Change gender ENUM to INT
            $table->integer('gender')->nullable()->change();

            // Change membership_type ENUM to INT
            $table->integer('membership_type')->nullable()->change();

            // Change trainer_assigned VARCHAR to INT (foreign key ready)
            $table->integer('trainer_assigned')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->enum('gender', ['male','female','other'])->nullable()->change();
            $table->enum('membership_type', ['basic','premium','vip'])->nullable()->change();
            $table->string('trainer_assigned')->nullable()->change();

        });
    }
};
