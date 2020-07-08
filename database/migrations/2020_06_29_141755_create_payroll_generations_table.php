<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_generations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id',15);
            $table->integer('regular_days');
            $table->integer('ot')->default(0);
            $table->integer('ut')->default(0);
            $table->date('payroll_date');
            $table->date('payroll_date_to');
            $table->bigInteger('generated_by');
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
        Schema::dropIfExists('payroll_generations');
    }
}
