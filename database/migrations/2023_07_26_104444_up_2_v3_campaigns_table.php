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
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->dropColumn(['is_recipients_verified']);
            $table->unsignedBigInteger('sms_invalid_count')->default(0)->after('sms_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('is_recipients_verified');
            $table->dropColumn(['sms_invalid_count']);
        });
    }
};
