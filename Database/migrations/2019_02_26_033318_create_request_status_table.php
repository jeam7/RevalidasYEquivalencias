<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('info')->nullable();
            $table->timestamps();
        });

        $dataRequestStatus = array(
            array('id' =>1, 'name' => 'Generada'),
            array('id' =>2, 'name' => 'Devuelta por falta de documentos'),
            array('id' =>3, 'name' => 'Enviada a la comision de revalidas y equivalencias'),
            array('id' =>4, 'name' => 'Enviada de la subcomision de revalidas y equivalencias'),
            array('id' =>5, 'name' => 'Enviada al consejo de facultad'),
            array('id' =>6, 'name' => 'Recibida por la direccion de revalidas y equivalencias'),
            array('id' =>7, 'name' => 'Enviada al consejo universitario'),
            array('id' =>8, 'name' => 'Procesada')
        );
      DB::table('request_status')->insert($dataRequestStatus);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_status');
    }
}
