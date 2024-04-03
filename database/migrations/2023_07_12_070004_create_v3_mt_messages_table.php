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
        Schema::create('v3_mt_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('telco')->default(0)->comment('1: vina, 2: viettel, 3: reddi, 4: mobi, 5: beeline, 6: htc, 7: korea, 8: us');
            $table->unsignedBigInteger('partner_id');
            $table->string('phone_number', 15);
            $table->unsignedBigInteger('mo_subscription_id');
            $table->text('text');
            $table->dateTime('delivered_at', 0)->nullable();
            $table->unsignedTinyInteger('is_delivered')->default(0);
            $table->unsignedTinyInteger('is_sent')->default(0);
            $table->unsignedTinyInteger('error')->default(0)->comment('0: ok');
            $table->timestamp('created_at', 0)->nullable();

            $table->index(['partner_id', 'created_at']);
            $table->index('vendor_id');
            $table->index('telco');
            $table->index('partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_mt_messages');
    }
};
