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
        Schema::table('interpretations', function (Blueprint $table) {
            $table->string('c_type')->nullable();
            $table->string('c_unit')->nullable();
            $table->decimal('c_rate', 8, 2)->nullable();
            $table->decimal('c_adjust', 8, 2)->nullable();
            $table->decimal('c_fee', 8, 2)->nullable();
            $table->text('c_adjust_note')->nullable();
            $table->integer('c_paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interpretations', function (Blueprint $table) {
            $table->dropColumn('c_type');
            $table->dropColumn('c_unit');
            $table->dropColumn('c_rate', 8, 2);
            $table->dropColumn('c_adjust', 8, 2);
            $table->dropColumn('c_fee', 8, 2);
            $table->dropColumn('c_adjust_note');
            $table->dropColumn('c_paid');
        });
    }
};
