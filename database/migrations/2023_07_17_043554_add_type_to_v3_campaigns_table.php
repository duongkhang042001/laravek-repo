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
            if (Schema::hasColumn('v3_campaigns', 'code')) {
                $table->dropColumn(['code']);
            }
            $table->unsignedTinyInteger('type')->default(1)->after('content')->comment('1: sms, 2: ssms, 3: hbbdsms, 4: qcsms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->dropColumn(['type']);
        });
    }
};
