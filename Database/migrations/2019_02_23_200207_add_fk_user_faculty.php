<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkUserFaculty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->integer('faculty_id')->unsigned()->nullable();
          $table->foreign('faculty_id', 'fk_user_faculty')->references('id')->on('faculties');
      });
      DB::update("UPDATE users SET faculty_id = 3 WHERE id IN (2,3)");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropForeign('fk_user_faculty');
      });
    }
}
