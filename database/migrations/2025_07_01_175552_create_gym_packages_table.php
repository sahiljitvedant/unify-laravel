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
        Schema::create('gym_packages', function (Blueprint $table) {
            $table->id();
            
            // Basic Details
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['Monthly', 'Quarterly', 'Yearly', 'Session'])->default('Monthly');

            // Pricing Details
            $table->decimal('price', 10, 2);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_packages');
    }
};
