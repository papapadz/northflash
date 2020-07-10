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
            $table->bigInteger('payroll_item');
            $table->double('amount',9,2);
            $table->integer('num_days')->default(1);
            $table->date('payroll_date');
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
