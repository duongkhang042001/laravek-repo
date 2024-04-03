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
        Schema::create('v3_user_has_brandnames', function (Blueprint $table) {
            $table->unsignedBigInteger('brandname_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('brandname_id')
                ->references('id')
                ->on('v3_brandnames')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('v3_users')
                ->onDelete('cascade');

            $table->primary(['brandname_id', 'user_id'], 'user_has_brandnames_brandname_id_user_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_user_has_brandnames');
    }
};
