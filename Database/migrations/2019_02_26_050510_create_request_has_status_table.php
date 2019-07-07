<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestHasStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_has_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id', 'fk_requestHasStatus_request')->references('id')->on('requests');
            $table->integer('request_status_id')->unsigned()->nullable();
            $table->foreign('request_status_id', 'fk_requestHasStatus_requestStatus')->references('id')->on('request_status');
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
        Schema::dropIfExists('request_has_status');
    }
}
