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
        Schema::create('v3_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('name', 250);
            $table->text('content');
            $table->unsignedTinyInteger('enabled')->default(0);
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            $table->index('partner_id');

            $table->foreign('partner_id')
                ->references('id')
                ->on('v3_partners')
                ->onDelete('cascade');
        });

        Schema::table('v3_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->after('brandname_id');

            $table->index('template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_templates');
    }
};
