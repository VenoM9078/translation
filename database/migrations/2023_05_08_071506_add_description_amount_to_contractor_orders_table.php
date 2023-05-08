<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractor_orders', function (Blueprint $table) {
            //add description and amount to contractor_orders table
            $table->text('description')->nullable();
            $table->string('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractor_orders', function (Blueprint $table) {
            //also drop them when rolling back
            $table->dropColumn('description');
            $table->dropColumn('amount');
        });
    }
};