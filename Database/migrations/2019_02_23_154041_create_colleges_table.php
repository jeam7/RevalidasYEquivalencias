<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('foreign', [1,2])->default(1);
            $table->string('address');
            $table->string('abbreviation')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        $dataCollege = array(
            array(
              'id' => 1,
              'name' => 'Universidad Central de Venezuela',
              'foreign' => 1,
              'address' => 'Ciudad Universitaria de Caracas',
              'abbreviation' => 'UCV'
            )
        );
      DB::table('colleges')->insert($dataCollege);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colleges');
    }
}
