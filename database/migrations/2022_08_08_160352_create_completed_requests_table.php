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
        Schema::create('completed_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->string('email');
            $table->string('completed_file');
            $table->string('translation_id');
            $table->string('proofreader_id');
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
        Schema::dropIfExists('completed_requests');
    }
};
