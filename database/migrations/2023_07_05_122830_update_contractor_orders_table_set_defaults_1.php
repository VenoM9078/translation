<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE contractor_orders MODIFY translation_type VARCHAR(255) DEFAULT 'By Word'");
        DB::statement("ALTER TABLE contractor_orders MODIFY translator_adjust INT DEFAULT 0");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE contractor_orders MODIFY translation_type VARCHAR(255) DEFAULT NULL");
        DB::statement("ALTER TABLE contractor_orders MODIFY translator_adjust INT DEFAULT NULL");
    }
};
