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
        Schema::table('v3_brandname_pricings', function (Blueprint $table) {
            $table->unsignedBigInteger('region_code')->default(0)->after('sms_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_brandname_pricings', function (Blueprint $table) {
            $table->dropColumn(['region_code']);
        });
    }
};
