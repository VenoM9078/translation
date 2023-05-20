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
        Schema::create('contractor_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('contractor_id');
            $table->integer('rate')->nullable();
            $table->integer('total_payment')->nullable();
            $table->integer('total_words')->nullable();
            $table->string('is_accepted');
            $table->string('file_name')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};