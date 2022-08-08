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
        Schema::create('proof_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('proofreader_email');
            $table->string('email_title');
            $table->text('email_body');
            $table->integer('proofread_status')->default(0);
            $table->string('translated_files');
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
        Schema::dropIfExists('proof_requests');
    }
};
