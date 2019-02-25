<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('faculty_id')->unsigned();
            $table->foreign('faculty_id', 'fk_school_faculty')->references('id')->on('faculties');
            $table->softDeletes();
            $table->timestamps();
        });

        $dataSchool = array(
            array('id' =>1, 'name' => 'Escuela de Biologia', 'faculty_id' => 1),
            array('id' =>2, 'name' => 'Escuela de Computacion', 'faculty_id' => 1),
            array('id' =>3, 'name' => 'Escuela de Fisica', 'faculty_id' => 1),
            array('id' =>4, 'name' => 'Escuela de Matematica', 'faculty_id' => 1),
            array('id' =>5, 'name' => 'Escuela de Quimica', 'faculty_id' => 1)
        );
      DB::table('schools')->insert($dataSchool);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
