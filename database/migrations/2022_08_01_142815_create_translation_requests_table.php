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
        Schema::create('translation_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('translator_email');
            $table->string('email_title');
            $table->text('email_body');
            $table->integer('translation_status')->default(0);
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
        Schema::dropIfExists('translation_requests');
    }
};
