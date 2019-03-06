<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('college_id')->unsigned();
            $table->foreign('college_id', 'fk_faculty_college')->references('id')->on('colleges');
            $table->softDeletes();
            $table->timestamps();
        });
        $dataFaculty = array(
            array(
              'id' => 1,
              'name' => 'Facultad de Agronomía',
              'college_id' => 1
            ),
            array(
              'id' => 2,
              'name' => 'Facultad de Arquitectura y Urbanismo',
              'college_id' => 1
            ),
            array(
              'id' => 3,
              'name' => 'Facultad de Ciencias',
              'college_id' => 1
            ),
            array(
              'id' => 4,
              'name' => 'Facultad de Ciencias Económicas y Sociales',
              'college_id' => 1
            ),
            array(
              'id' => 5,
              'name' => 'Facultad de Farmacia',
              'college_id' => 1
            ),
            array(
              'id' => 6,
              'name' => 'Facultad de Humanidades y Educación',
              'college_id' => 1
            ),
            array(
              'id' => 7,
              'name' => 'Facultad de Ingeniería',
              'college_id' => 1
            ),
            array(
              'id' => 8,
              'name' => 'Facultad de Ciencias Jurídicas y Políticas',
              'college_id' => 1
            ),

            array(
              'id' => 9,
              'name' => 'Facultad de Medicina',
              'college_id' => 1
            ),
            array(
              'id' => 10,
              'name' => 'Facultad de Odontología',
              'college_id' => 1
            ),
            array(
              'id' => 11,
              'name' => 'Facultad de Veterinaria',
              'college_id' => 1
            )
        );
      DB::table('faculties')->insert($dataFaculty);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculties');
    }
}
