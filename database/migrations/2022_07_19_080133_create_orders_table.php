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
            $table->string('casemanager')->nullable(true);
            $table->string('access_code')->nullable(true);
            $table->integer('paymentStatus')->default(0);
            $table->integer('paymentLaterApproved')->default(0);
            $table->string('payLaterCode')->nullable(true);
            $table->integer('invoiceSent')->default(0);
            $table->integer('is_evidence')->default(0);
            $table->string('filename')->nullable(true);
            $table->integer('evidence_accepted')->default(0);
            $table->integer('amount')->default(0);
            $table->string('orderStatus')->default('Invoice Pending');
            $table->integer('translation_status')->default(0);
            $table->integer('proofread_status')->default(0);
            $table->integer('completed')->default(0);


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
