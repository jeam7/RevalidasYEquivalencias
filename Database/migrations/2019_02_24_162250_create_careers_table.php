<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('school_id')->unsigned();
          $table->foreign('school_id', 'fk_career_school')->references('id')->on('schools');
          $table->softDeletes();
          $table->timestamps();
        });

        $dataCareer = array(
            array('id' =>1, 'name' => 'Licenciatura en Biologia', 'school_id' => 1),
            array('id' =>2, 'name' => 'Licenciatura en Computacion', 'school_id' => 2),
            array('id' =>3, 'name' => 'Licenciatura en Fisica', 'school_id' => 3),
            array('id' =>4, 'name' => 'Licenciatura en Matematica', 'school_id' => 4),
            array('id' =>5, 'name' => 'Licenciatura en Quimica', 'school_id' => 5),
            array('id' =>6, 'name' => 'Licenciatura en Geoquimica', 'school_id' => 5)
        );
      DB::table('careers')->insert($dataCareer);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
}
