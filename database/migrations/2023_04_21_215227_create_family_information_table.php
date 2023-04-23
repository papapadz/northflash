<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',15);
            $table->string('relationship');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
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
        Schema::table('family_information', function (Blueprint $table) {
            //
        });
    }
}
