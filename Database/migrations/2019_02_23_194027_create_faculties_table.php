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
              'name' => 'Facultad de Ciencias',
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
