<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePayrollGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_generations', function (Blueprint $table) {
            $table->dropColumn('num_days');
            $table->dropColumn('generated_by');
            $table->dropColumn('payroll_date');
            $table->bigInteger('updated_by');
            $table->double('qty',9,2)->default(1);
            $table->bigInteger('payroll_master_id');
            $table->double('total',9,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_generations', function (Blueprint $table) {
            $table->integer('num_days');
            $table->bigInteger('generated_by');
            $table->date('payroll_date');
            $table->bigInteger('updated_by');
            $table->dropColumn('qty');
            $table->dropColumn('payroll_master_id');
            $table->dropColumn('total');
        });
    }
}
