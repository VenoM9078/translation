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
        Schema::create('contractor_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('contractor_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('contractor_type')->nullable();
            $table->integer('is_admin')->default(0);
            
            $table->integer('old_translation_status')->nullable();
            $table->integer('new_translation_status')->nullable();

            $table->integer('old_proof_read_sent_status')->nullable();
            $table->integer('new_proof_read_sent_status')->nullable();

            $table->integer('new_interpretation_sent_status')->nullable();
            $table->integer('old_interpretation_sent_status')->nullable();


            $table->integer('is_accepted')->nullable();
            $table->string('action')->nullable();
            $table->string('model_name')->nullable();
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
        Schema::dropIfExists('contractor_logs');
    }
};