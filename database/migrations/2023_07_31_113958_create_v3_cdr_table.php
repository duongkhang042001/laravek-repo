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
        Schema::create('v3_cdr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('mo_message_id');
            $table->unsignedBigInteger('mo_subscription_id');
            $table->unsignedTinyInteger('telco')->default(0);
            $table->string('phone_number', 15);
            $table->text('text');
            $table->unsignedInteger('sms_count')->default(0);
            $table->dateTime('delivered_at', 0)->nullable();
            $table->unsignedTinyInteger('is_sent')->default(0);
            $table->unsignedTinyInteger('error')->default(0)->comment('0: ok');
            $table->timestamp('created_at', 0)->nullable();
            
            $table->index(['partner_id', 'created_at']);
            $table->index('telco');
            $table->index('partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_cdr');
    }
};
