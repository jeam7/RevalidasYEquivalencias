<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id', 'fk_voucher_request')->references('id')->on('requests');
            $table->longtext('observations')->nullable();
            $table->date('date_subcomi_eq')->nullable();
            $table->date('date_comi_eq')->nullable();
            $table->date('date_con_fac')->nullable();
            $table->date('date_con_univ')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
