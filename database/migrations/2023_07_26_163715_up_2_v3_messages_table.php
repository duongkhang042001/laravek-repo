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
        Schema::table('v3_messages', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->nullable()->after('text_lenght');
            $table->unsignedTinyInteger('tries')->default(0)->after('error');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_messages', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'tries']);
        });
    }
};
