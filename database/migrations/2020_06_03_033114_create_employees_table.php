<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('employee_id',15)->primary();
            $table->string('first_name',50);
            $table->string('middle_name',50)->nullable();
            $table->string('last_name',50);
            $table->date('birthdate');
            $table->string('gender',1);
            $table->string('civil_stat',50);
            $table->string('address',255);
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
        Schema::dropIfExists('employees');
    }
}
