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
            $table->dropColumn(['sms_total']);

            $table->unsignedBigInteger('sms_count')->default(0)->after('scheduled_at');
            $table->unsignedBigInteger('sms_failed_count')->default(0)->after('scheduled_at');
            $table->unsignedBigInteger('sms_deliveried_count')->default(0)->change()->after('scheduled_at');
            $table->unsignedBigInteger('sms_sent_count')->default(0)->after('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('sms_total')->default(0);

            $table->dropColumn(['sms_count', 'sms_failed_count', 'sms_sent_count']);
        });
    }
};
