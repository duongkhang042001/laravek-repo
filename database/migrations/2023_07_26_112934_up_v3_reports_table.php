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
        Schema::table('v3_reports', function (Blueprint $table) {
            $table->dropColumn('telco');
        });

        Schema::table('v3_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->after('brandname_id');
            $table->renameColumn('date', 'delivered_on');
            $table->unsignedTinyInteger('telco')->default(0)->after('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_reports', function (Blueprint $table) {
            $table->dropColumn(['campaign_id']);
            $table->renameColumn('delivered_on', 'date');
        });
    }
};
