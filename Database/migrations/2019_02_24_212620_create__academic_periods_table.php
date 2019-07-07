<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faculty_id')->unsigned()->nullable();
            $table->foreign('faculty_id', 'fk_academidPeriod_faculty')->references('id')->on('faculties');
            // $table->integer('college_id')->unsigned();
            // $table->foreign('college_id', 'fk_academidPeriod_college')->references('id')->on('colleges');
            $table->string('name');
            $table->string('info')->nullable();
            $table->string('dean');
            $table->string('rep_sub_equi_one');
            $table->string('rep_sub_equi_two');
            $table->string('rep_sub_equi_three');
            $table->string('rep_comi_equi_one');
            $table->string('rep_comi_equi_two');
            $table->string('rep_comi_equi_three');
            $table->softDeletes();
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
        Schema::dropIfExists('academic_periods');
    }
}
