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
            $table->unsignedInteger('sms_count')->default(0)->after('text');

            if (Schema::hasColumn('v3_mt_messages', 'vendor_id')) {
                $table->dropColumn(['vendor_id']);
            }
            $table->unsignedTinyInteger('provider')->after('id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->unsignedInteger('vendor_id')->after('id');

            $table->index('vendor_id');

            $table->dropColumn(['sms_count', 'provider']);
        });
    }
};
