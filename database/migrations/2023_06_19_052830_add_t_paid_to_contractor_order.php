<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractor_orders', function (Blueprint $table) {
            $table->integer('translator_paid')->nullable();
            $table->integer('translator_unit')->nullable();
            $table->integer('translator_adjust')->nullable();
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
            //
        });
    }
};