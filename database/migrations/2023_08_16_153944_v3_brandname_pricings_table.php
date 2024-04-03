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
            // Add the new column region_code
            $table->string('region_code')->after('country_code');

            // Remove the column vendor_id if it exists
            if (Schema::hasColumn('v3_mt_messages', 'vendor_id')) {
                $table->dropColumn('vendor_id');
            }

            // Add the new column provider
            $table->unsignedTinyInteger('provider')->after('id')->default(0);

            // Add the new column sms_count
            $table->unsignedInteger('sms_count')->default(0)->after('text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_mt_messages', function (Blueprint $table) {
            $table->dropColumn(['region_code']);
        });
    }
};
