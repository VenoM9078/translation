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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('worknumber');
            $table->string('language1');
            $table->string('language2');
            $table->string('casemanager');
            $table->string('access_code');
            $table->integer('paymentStatus')->default(0);
            $table->integer('invoiceSent')->defautl(0);
            $table->integer('amount')->default(0);
            $table->string('orderStatus')->default('Invoice Pending');
            $table->integer('translation_status')->default(0);
            $table->integer('proofread_status')->defautl(0);
            $table->integer('completed')->defautl(0);


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
        Schema::dropIfExists('orders');
    }
};
