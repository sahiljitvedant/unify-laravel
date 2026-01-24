<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('headers', function (Blueprint $table) {
            $table->id(); // only auto increment column
            $table->string('title');
            $table->unsignedInteger('sequence_no'); // NO auto increment
            $table->boolean('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0); // 0 = active, 9 = deleted
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headers');
    }
};
