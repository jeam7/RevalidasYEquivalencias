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
            array('id' =>1, 'name' => 'Escuela de Agronomia', 'faculty_id' => 1),

            array('id' =>2, 'name' => 'Escuela de Arquitectura', 'faculty_id' => 2),

            array('id' =>3, 'name' => 'Escuela de Biologia', 'faculty_id' => 3),
            array('id' =>4, 'name' => 'Escuela de Computacion', 'faculty_id' => 3),
            array('id' =>5, 'name' => 'Escuela de Fisica', 'faculty_id' => 3),
            array('id' =>6, 'name' => 'Escuela de Matematica', 'faculty_id' => 3),
            array('id' =>7, 'name' => 'Escuela de Quimica', 'faculty_id' => 3),
            array('id' =>8, 'name' => 'Escuela de Geoquimica', 'faculty_id' => 3),

            array('id' =>9, 'name' => 'Escuela Administracion y Contaduria', 'faculty_id' => 4),
            array('id' =>10, 'name' => 'Escuela Antropologia', 'faculty_id' => 4),
            array('id' =>11, 'name' => 'Escuela Estadisticas y Ciencias Actuariales', 'faculty_id' => 4),
            array('id' =>12, 'name' => 'Escuela Economia', 'faculty_id' => 4),
            array('id' =>13, 'name' => 'Escuela Estudios Internacionales', 'faculty_id' => 4),
            array('id' =>14, 'name' => 'Escuela Sociologia', 'faculty_id' => 4),
            array('id' =>15, 'name' => 'Escuela Trabajo Social', 'faculty_id' => 4),

            array('id' =>16, 'name' => 'Escuela Farmacia', 'faculty_id' => 5),

            array('id' =>17, 'name' => 'Escuela Artes', 'faculty_id' => 6),
            array('id' =>18, 'name' => 'Escuela Bibliotecologia y Archivologia', 'faculty_id' => 6),
            array('id' =>19, 'name' => 'Escuela Comunicacion Social', 'faculty_id' => 6),
            array('id' =>20, 'name' => 'Escuela Educacion', 'faculty_id' => 6),
            array('id' =>21, 'name' => 'Escuela Filosofia', 'faculty_id' => 6),
            array('id' =>22, 'name' => 'Escuela Geografia', 'faculty_id' => 6),
            array('id' =>23, 'name' => 'Escuela Historia', 'faculty_id' => 6),
            array('id' =>24, 'name' => 'Escuela Idiomas Modernos', 'faculty_id' => 6),
            array('id' =>25, 'name' => 'Escuela Letras', 'faculty_id' => 6),
            array('id' =>26, 'name' => 'Escuela Psicologia', 'faculty_id' => 6),

            array('id' =>27, 'name' => 'Escuela Ciclo Basico', 'faculty_id' => 7),
            array('id' =>28, 'name' => 'Escuela Civil', 'faculty_id' => 7),
            array('id' =>29, 'name' => 'Escuela Electrica', 'faculty_id' => 7),
            array('id' =>30, 'name' => 'Escuela Feologia, Minas y Geofisica', 'faculty_id' => 7),
            array('id' =>31, 'name' => 'Escuela Mecanica', 'faculty_id' => 7),
            array('id' =>32, 'name' => 'Escuela Metalurgica y Ciencias de los Materiales', 'faculty_id' => 7),
            array('id' =>33, 'name' => 'Escuela Ingenieria Quimica', 'faculty_id' => 7),
            array('id' =>34, 'name' => 'Escuela Petroleo', 'faculty_id' => 7),


            array('id' =>35, 'name' => 'Escuela Derecho', 'faculty_id' => 8),
            array('id' =>36, 'name' => 'Escuela Estudios Politicos y Administrativos', 'faculty_id' => 8),

            array('id' =>37, 'name' => 'Escuela Bioanálisis', 'faculty_id' => 9),
            array('id' =>38, 'name' => 'Escuela Enfermería', 'faculty_id' => 9),
            array('id' =>39, 'name' => 'Escuela José María Vargas', 'faculty_id' => 9),
            array('id' =>40, 'name' => 'Escuela Luis Razetti', 'faculty_id' => 9),
            array('id' =>41, 'name' => 'Escuela Nutrición y Dietética', 'faculty_id' => 9),
            array('id' =>42, 'name' => 'Escuela Salud Pública', 'faculty_id' => 9),

            array('id' =>43, 'name' => 'Escuela Odontologia', 'faculty_id' => 10),

            array('id' =>44, 'name' => 'Escuela de Ciencias Veterinarias', 'faculty_id' => 11)
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
