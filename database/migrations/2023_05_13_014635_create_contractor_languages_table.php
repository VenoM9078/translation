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
        Schema::create('contractor_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractor_id');
            $table->foreign('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->string('language');
            $table->boolean('is_translator')->default(0);
            $table->boolean('is_interpreter')->default(0);
            $table->boolean('is_proofreader')->default(0);
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
        Schema::dropIfExists('contractor_languages');
    }
};
