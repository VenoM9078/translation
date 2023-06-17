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
        Schema::table('proof_reader_orders', function (Blueprint $table) {
            $table->integer('proof_read_paid')->nullable();
            $table->text('proof_read_adjust_note')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proof_reader_orders', function (Blueprint $table) {
            //
        });
    }
};
