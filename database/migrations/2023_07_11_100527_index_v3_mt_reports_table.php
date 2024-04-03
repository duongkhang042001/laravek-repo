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
        Schema::table('v3_mt_reports', function (Blueprint $table) {
            $table->dropIndex(['partner_id', 'mo_subscription_id']);
            $table->index(['mo_subscription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_mt_reports', function (Blueprint $table) {
            $table->index(['partner_id', 'mo_subscription_id']);
            $table->dropIndex(['mo_subscription_id']);
        });
    }
};
