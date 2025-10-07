<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_user_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // new user_id column
            $table->unsignedBigInteger('preference_id');
            $table->boolean('is_active')->default(1);
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_user_preferences');
    }
};
