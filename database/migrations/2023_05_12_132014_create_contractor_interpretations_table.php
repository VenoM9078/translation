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
        Schema::create('contractor_interpretations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('interpretation_id');
            $table->boolean('is_accepted')->default(0);
            $table->date('dateDecided')->nullable();
            $table->text('description')->nullable();
            $table->float('estimated_payment')->default(0); // new field
            $table->float('per_hour_rate')->default(0); // new field
            $table->time('start_time_decided')->nullable();
            $table->time('end_time_decided')->nullable();
            $table->timestamps();

            $table->foreign('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->foreign('interpretation_id')->references('id')->on('interpretations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractor_interpretations');
    }
};
