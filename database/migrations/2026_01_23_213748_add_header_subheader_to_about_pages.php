<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {

            $table->unsignedBigInteger('header_id')->after('slug');
            $table->unsignedBigInteger('subheader_id')->nullable()->after('header_id');

            $table->longText('description')->after('subheader_id');

            // ❌ REMOVE this line
            // $table->tinyInteger('is_deleted')->default(0)->after('status');

            $table->foreign('header_id')
                ->references('id')
                ->on('headers')
                ->onDelete('cascade');

            $table->foreign('subheader_id')
                ->references('id')
                ->on('subheaders')
                ->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
    
            $table->dropForeign(['header_id']);
            $table->dropForeign(['subheader_id']);
    
            $table->dropColumn([
                'header_id',
                'subheader_id',
                'description'
            ]);
        });
    }
    
};
