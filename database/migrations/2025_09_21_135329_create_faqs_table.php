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
        Schema::create('tbl_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('youtube_link')->nullable();
            $table->string('faq_image')->nullable();
            $table->tinyInteger('status')->default(1); // 1 = active, 0 = inactive
            $table->tinyInteger('is_deleted')->default(0); // 0 = not deleted, 9 = deleted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_faqs');
    }
};
