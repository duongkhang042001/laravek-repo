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
        Schema::create('v3_file_imports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('path');
            $table->unsignedBigInteger('size')->default(0)->comment('bytes');
            $table->timestamps();

            $table->index('partner_id');
        });

        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('file_import_id')->nullable()->after('template_id');

            $table->index('file_import_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_file_imports');
    }
};
