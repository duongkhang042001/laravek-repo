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
            // $table->dropColumn(['vendor_id', 'telco']);
        });

        Schema::table('v3_messages', function (Blueprint $table) {
            $table->unsignedTinyInteger('telco')->default(0)->after('ukey');
            $table->unsignedTinyInteger('provider')->default(0)->after('ukey');

            $table->unsignedInteger('text_lenght')->default(0)->after('text');
            $table->unsignedTinyInteger('is_encrypted')->default(0)->after('is_sent');
            $table->unsignedTinyInteger('is_unicode')->default(0)->after('is_sent');
            $table->unsignedTinyInteger('is_intl')->default(0)->after('is_sent');
            $table->unsignedTinyInteger('is_otp')->default(0)->after('is_sent');
            $table->dateTime('sent_at')->nullable()->after('is_sent');

            $table->string('sender')->nullable()->after('campaign_id');
            $table->renameColumn('phone_number', 'recipent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('v3_messages', function (Blueprint $table) {
            $table->unsignedTinyInteger('vendor_id')->default(0)->after('ukey');

            $table->dropColumn(['provider', 'sender', 'text_lenght', 'is_encrypted', 'is_unicode', 'is_intl', 'is_otp']);
        });
    }
};
