<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->date('dob')->nullable()->change();
            $table->string('middle_name')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('residence_address')->nullable()->change();
            $table->string('residence_area')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('membership_type')->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->date('expiry_date')->nullable()->change();
            $table->decimal('amount_paid', 10, 2)->nullable()->change();
            $table->string('payment_method')->nullable()->change();
            $table->string('trainer_assigned')->nullable()->change();
            $table->text('fitness_goals')->nullable()->change();
            $table->string('preferred_workout_time')->nullable()->change();
            $table->decimal('current_weight', 8, 2)->nullable()->change();
            $table->text('additional_notes')->nullable()->change();
            $table->string('profile_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->date('dob')->nullable(false)->change();
            $table->string('middle_name')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            // Repeat for other columns if needed
        });
    }
};
