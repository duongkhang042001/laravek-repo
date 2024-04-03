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
        Schema::create('v3_telcos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->timestamps();
        });

        Schema::create('v3_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->timestamps();
        });

        Schema::create('v3_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('telco')->default(0)->comment('1: vina, 2: viettel, 3: reddi, 4: mobi, 5: beeline, 6: htc, 7: korea, 8: us');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('brandname_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->string('phone_number', 15);
            $table->unsignedTinyInteger('type')->default(1)->comment('1: CSKH, 2: QC, 3: MO, 4: MT');
            $table->unsignedTinyInteger('is_MT')->default(0);
            $table->text('text');
            $table->dateTime('delivered_at', 0)->nullable();
            $table->unsignedTinyInteger('is_delivered')->default(0);
            $table->unsignedTinyInteger('is_sent')->default(0);
            $table->unsignedTinyInteger('error')->default(0)->comment('0: ok');
            $table->timestamp('created_at', 0)->nullable();

            $table->index(['partner_id', 'campaign_id', 'created_at']);
            $table->index(['partner_id', 'created_at']);
            $table->index('vendor_id');
            $table->index('telco');
            $table->index('partner_id');
            $table->index('brandname_id');
            $table->index('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_telcos');
        Schema::dropIfExists('v3_vendors');
        Schema::dropIfExists('v3_messages');
    }
};
