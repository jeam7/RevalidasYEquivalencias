<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('code')->nullable();
          $table->string('info')->nullable();
          $table->integer('credits');
          $table->integer('career_id')->unsigned()->nullable();
          $table->foreign('career_id', 'fk_subject_career')->references('id')->on('careers');
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
        Schema::dropIfExists('subjects');
    }
}
