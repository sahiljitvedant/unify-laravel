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
        Schema::create('tbl_gym_membership', function (Blueprint $table) {
            $table->id();
           
            $table->string('membership_name', 150)->comment('Membership Name'); // Membership Name
            $table->text('description')->nullable()->comment('Description of the membership'); // Description
            $table->integer('duration_in_days')->comment('Duration of membership in days'); // Duration in days
            $table->decimal('price', 10, 2)->comment('Price of membership'); // Price
            $table->enum('trainer_included', ['yes','no'])->comment('Trainer included (yes/no)'); // Trainer included or not
            $table->json('facilities_included')->nullable()->comment('Facilities included (JSON array of IDs)'); // Facilities
            $table->boolean('is_active')->default(1)->comment('Status: 1 = Active, 0 = Inactive'); // Status
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_gym_membership');
    }
};
