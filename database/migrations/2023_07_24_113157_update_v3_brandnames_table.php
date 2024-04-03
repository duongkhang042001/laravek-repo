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
        Schema::table('v3_brandnames', function (Blueprint $table) {
            $table->unsignedInteger('vendor_id')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_brandnames', function (Blueprint $table) {
            $table->dropColumn(['vendor_id']);
        });
    }
};
