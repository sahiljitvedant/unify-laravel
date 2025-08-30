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
        Schema::create('tbl_trainer', function (Blueprint $table) {
            $table->id();
            $table->string('trainer_name');        
            $table->boolean('is_active')->default(1); 
            $table->date('joining_date');        
            $table->date('expiry_date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_trainer');
    }
};
