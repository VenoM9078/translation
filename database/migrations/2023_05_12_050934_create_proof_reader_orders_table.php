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
        Schema::create('proof_reader_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('contractor_id')->nullable();
            $table->integer('translation_status')->nullable();
            $table->integer('is_accepted')->nullable();
            $table->integer('contractor_order_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('proof_reader_orders');
    }
};
