<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subheaders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('header_id')
                ->references('id')
                ->on('headers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subheaders');
    }
};
