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
        Schema::create('interpretations', function (Blueprint $table) {
            $table->id();
            $table->string('worknumber');
            $table->integer('user_id');
            $table->string('language');
            $table->date('interpretationDate');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('session_format');
            $table->string('location');
            $table->text('session_topics');
            $table->boolean('wantQuote')->default(0);
            $table->double('quote_price')->nullable(true);
            $table->string('quote_description')->nullable(true);
            $table->boolean('invoiceSent')->default(0);
            $table->boolean('paymentStatus')->default(0);
            $table->integer('interpreter_id')->nullable(true);
            $table->boolean('interpreter_completed')->default(0);
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
        Schema::dropIfExists('interpretations');
    }
};
