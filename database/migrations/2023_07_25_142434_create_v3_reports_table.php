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
        Schema::create('v3_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('brandname_id');
            $table->unsignedInteger('telco')->default(0);
            $table->unsignedTinyInteger('sms_type')->default(0);
            $table->unsignedBigInteger('sms_count')->default(0);
            $table->unsignedBigInteger('sms_sent_count')->default(0);
            $table->unsignedBigInteger('sms_pending_count')->default(0);
            $table->unsignedBigInteger('sms_failed_count')->default(0);
            $table->decimal('subtotal', 16, 4);
            $table->decimal('fees', 16, 4);
            $table->decimal('amount', 16, 4);
            $table->date('date');

            $table->index(['partner_id', 'date']);
            $table->index(['partner_id', 'brandname_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_reports');
    }
};
