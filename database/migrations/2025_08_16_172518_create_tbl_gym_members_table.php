<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_gym_members', function (Blueprint $table) {
            $table->id();
            
            // Step 1 - Personal Info
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('email')->unique();
            $table->string('mobile', 10);
            $table->string('residence_address');
            $table->text('residence_area')->nullable();
            $table->string('zipcode', 6);
            $table->string('city');
            $table->string('state');
            $table->string('country');

            // Step 2 - Membership Info
            $table->enum('membership_type', ['basic','premium','vip']); // adjust values as needed
            $table->date('joining_date');
            $table->date('expiry_date');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method');
            $table->string('trainer_assigned');

            // Step 3 - Fitness Info
            $table->enum('fitness_goals', ['weight_loss','muscle_gain','flexibility','general_fitness']);
            $table->enum('preferred_workout_time', ['morning','afternoon','evening']);
            $table->decimal('current_weight', 5, 2)->nullable();
            $table->text('additional_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_gym_members');
    }
};
