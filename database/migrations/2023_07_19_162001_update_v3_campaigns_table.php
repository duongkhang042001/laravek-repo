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
            $table->dateTime('cancelled_at')->nullable()->after('scheduled_at');
            $table->unsignedInteger('sms_deliveried_count')->default(0)->after('scheduled_at');
            $table->unsignedInteger('sms_total')->default(0)->after('scheduled_at');
            $table->unsignedTinyInteger('is_recipients_verified')->default(0)->after('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->dropColumn(['sms_deliveried_count', 'sms_total', 'cancelled_at']);
        });
    }
};
