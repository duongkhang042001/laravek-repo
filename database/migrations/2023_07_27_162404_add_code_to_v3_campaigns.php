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
            $table->char('code', 25)->after('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->dropColumn(['code']);
        });
    }
};
