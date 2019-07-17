<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id', 'fk_request_user')->references('id')->on('users');
            $table->integer('career_origin_id')->unsigned()->nullable();
            $table->foreign('career_origin_id', 'fk_request_careerOrigin')->references('id')->on('careers');
            $table->integer('career_destination_id')->unsigned()->nullable();
            $table->foreign('career_destination_id', 'fk_request_careerDestination')->references('id')->on('careers');
            $table->enum('origin',[1,2]);
            $table->boolean('others')->nullable();
            $table->string('info_others')->nullable();
            $table->boolean('pensum')->nullable();
            $table->boolean('notes')->nullable();
            $table->boolean('study_programs')->nullable();
            $table->boolean('title')->nullable();
            $table->boolean('copy_ci')->nullable();
            $table->boolean('ci_passport_copy')->nullable();
            $table->boolean('notes_legalized')->nullable();
            $table->boolean('study_program_legalized')->nullable();
            $table->boolean('cerification_category_college')->nullable();
            $table->boolean('certification_title_no_confered')->nullable();
            $table->boolean('translation')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('requests');
    }
}
