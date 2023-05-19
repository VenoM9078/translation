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
        Schema::table('proof_reader_orders', function (Blueprint $table) {
            $table->string('file_name')->nullable();
            $table->string('feedback')->nullable();
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
            $table->dropColumn('file_name');
            $table->dropColumn('feedback');
        });
    }
};