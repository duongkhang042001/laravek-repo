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
        Schema::create('v3_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('username', 50);
            $table->string('full_name');
            $table->string('phone_number', 15)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('enabled')->default(1);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            $table->index('partner_id');
            $table->index('username');

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
        Schema::dropIfExists('v3_users');
    }
};
