<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePayrollItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->string('unit',20)->nullable();
            $table->boolean('is_manual_entry')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn('is_manual_entry');
        });
    }
}
