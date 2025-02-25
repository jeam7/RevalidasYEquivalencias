<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquivalentSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equivalent_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_id')->unsigned()->nullable();
            $table->foreign('voucher_id', 'fk_equivalentSubjects_voucher')->references('id')->on('vouchers');
            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id', 'fk_equivalentSubjects_subject')->references('id')->on('subjects');
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
        Schema::dropIfExists('equivalent_subjects');
    }
}
