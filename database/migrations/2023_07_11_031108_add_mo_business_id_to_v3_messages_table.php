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
            $table->unsignedInteger('mo_business_id')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_messages', function (Blueprint $table) {
            $table->dropColumn((['mo_business_id']));
        });
    }
};
