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
        Schema::create('v3_mt_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedInteger('telco')->default(0)->comment('1: vina, 2: viettel, 3: reddi, 4: mobi, 5: beeline, 6: htc, 7: korea, 8: us');
            $table->unsignedBigInteger('mo_subscription_id');
            $table->unsignedBigInteger('mo_sms_total');
            $table->unsignedBigInteger('mt_cdr_total');
            $table->unsignedBigInteger('mt_sms_total');
            $table->decimal('amount', 12, 2);
            $table->date('date');

            $table->index(['partner_id', 'date']);
            $table->index(['partner_id', 'mo_subscription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_mt_reports');
    }
};
