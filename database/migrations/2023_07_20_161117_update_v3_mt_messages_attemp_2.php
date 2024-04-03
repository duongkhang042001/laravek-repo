<?php

use App\Enums\Telco;
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
            $table->dropColumn(['telco']);
        });

        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->unsignedTinyInteger('telco')->default(0)->after('phone_number');
            $table->unsignedBigInteger('mo_message_id')->after('partner_id');
            $table->unsignedBigInteger('mo_subscription_id')->after('partner_id')->change();
            $table->unsignedTinyInteger('is_charged')->default(0)->after('is_sent');

            $table->dropIndex(['partner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->dropColumn(['mo_message_id']);

            $table->index(['partner_id']);
        });
    }
};
