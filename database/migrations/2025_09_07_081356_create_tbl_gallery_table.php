<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('gallery_name', 150);
            $table->boolean('is_active')->default(1);
            $table->string('main_thumbnail')->nullable();
            $table->json('gallery_images')->nullable();   // store images as JSON array
            $table->json('youtube_links')->nullable();    // store links as JSON array
            $table->boolean('is_deleted')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_gallery');
    }
};
