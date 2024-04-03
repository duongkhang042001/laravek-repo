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
        Schema::create('v3_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedInteger('brandname_id');
            $table->char('code', 100);
            $table->string('title', 250);
            $table->text('content');
            $table->unsignedTinyInteger('type')->comment('Kiểu chiến dịch => 1: CSKH, 2: QC');
            $table->unsignedTinyInteger('status')->default(1)->comment('1: new (default), 2: peding, 3:sending, 4: sent, 5: cancel');
            $table->timestamp('scheduled_at', 0)->nullable();
            $table->timestamp('approved_at', 0)->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();


            $table->index('partner_id');
            $table->index('brandname_id');
            $table->index('code');
            $table->index('approved_by');

            $table->foreign('partner_id')
                ->references('id')
                ->on('v3_partners')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v3_campaigns');
    }
};
