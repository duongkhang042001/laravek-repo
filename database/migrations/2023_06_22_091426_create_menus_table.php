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
        Schema::create('v3_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->unsignedBigInteger('partner_id');
            $table->string('pers')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            $table->index('partner_id');
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_menus');
    }
};
