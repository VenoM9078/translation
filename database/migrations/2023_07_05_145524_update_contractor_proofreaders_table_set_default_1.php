<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE proof_reader_orders MODIFY proofread_type VARCHAR(255) DEFAULT 'By Word'");
        DB::statement("ALTER TABLE proof_reader_orders MODIFY p_adjust INT DEFAULT 0");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE proof_reader_orders MODIFY proofread_type VARCHAR(255) DEFAULT NULL");
        DB::statement("ALTER TABLE proof_reader_orders MODIFY p_adjust INT DEFAULT NULL");
    }
};
