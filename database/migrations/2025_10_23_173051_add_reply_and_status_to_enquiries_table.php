<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_enquiry', function (Blueprint $table) {
            $table->text('reply')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 = pending, 1 = replied');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_enquiry', function (Blueprint $table) {
            $table->dropColumn(['reply', 'status']);
        });
    }
};
