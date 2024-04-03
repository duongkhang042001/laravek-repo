<?php

use App\Enums\Telco;
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
        Schema::create('v3_mo_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vendor_id');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('mo_subscription_id');
            $table->string('phone_number', 15);
            $table->unsignedTinyInteger('telco')->default(0)->comment(json_encode(Telco::toArray()));
            $table->text('text');
            $table->dateTime('received_at', 0)->nullable();
            $table->timestamp('created_at');

            $table->index(['partner_id', 'received_at']);
            $table->index(['partner_id', 'phone_number']);
            $table->index('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_mo_messages');
    }
};
