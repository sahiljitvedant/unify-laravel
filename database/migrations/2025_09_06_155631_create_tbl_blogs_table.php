<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_title', 150);
            $table->text('description');
            $table->date('publish_date');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_blogs');
    }
};
