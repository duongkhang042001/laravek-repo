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
            if (Schema::hasColumn('v3_messages', 'mo_business_id')) {
                $table->dropColumn(['mo_business_id']);
            }

            if (Schema::hasColumn('v3_messages', 'is_MT')) {
                $table->dropColumn(['is_MT']);
            }

            if (Schema::hasColumn('v3_messages', 'msg_type')) {
                $table->dropColumn(['msg_type']);
            }

            $table->unsignedTinyInteger('sms_type')->default(1)->after('phone_number')->comment('1: sms, 2: ssms, 3: hbbdsms, 4: qcsms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_messages', function (Blueprint $table) {
            $table->dropColumn(['sms_type']);
        });
    }
};
