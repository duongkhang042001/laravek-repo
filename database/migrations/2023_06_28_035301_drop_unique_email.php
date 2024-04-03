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
        Schema::table('v3_users', function (Blueprint $table) {

            $table->unsignedTinyInteger('is_admin')->default(0)->after('email');

            $table->dropUnique('v3_users_email_unique');

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_users', function (Blueprint $table) {
            //
        });
    }
};
