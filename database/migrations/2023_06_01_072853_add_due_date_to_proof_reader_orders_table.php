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
            $table->date('proof_read_due_date')->nullable();
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
            $table->dropColumn('proof_read_due_date');
        });
    }
};
