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
        Schema::create('v3_mo_businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('partner_id');
            $table->string('business_number', 15)->nullable();
            $table->string('business_number_format', 15)->nullable();
            $table->text('body');
            $table->timestamps();

            $table->index(['partner_id', 'business_number']);

            $table->foreign('partner_id')
                ->references('id')
                ->on('v3_partners')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_mo_businesses');
    }
};
