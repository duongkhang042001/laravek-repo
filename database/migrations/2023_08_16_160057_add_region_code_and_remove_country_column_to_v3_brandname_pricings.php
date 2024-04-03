<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('v3_brandname_pricings', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('region_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('v3_brandname_pricings', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('region_code')->nullable();
        });
    }
};
