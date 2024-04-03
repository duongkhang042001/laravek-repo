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
        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->index(['partner_id', 'phone_number']);
            $table->index(['partner_id', 'charged_at']);
            $table->index(['partner_id', 'delivered_at']);
            $table->index(['partner_id', 'is_charged', 'delivered_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->dropIndex(['partner_id', 'phone_number']);
            $table->indedropIndexx(['partner_id', 'charged_at']);
            $table->dropIndex(['partner_id', 'delivered_at']);
            $table->dropIndex(['partner_id', 'is_charged', 'delivered_at']);
        });
    }
};
