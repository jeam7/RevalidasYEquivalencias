<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('ci')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('place_birth')->nullable();
            $table->enum('nacionality', ['v','e'])->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('type_user',[1,2,3,4])->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        $dataAdmins = array(
            array(
              'email' => 'superadmin@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 1111111,
              'first_name' => 'N Super Admin',
              'last_name' => 'A Super Admin',
              'place_birth' => 'Caracas',
              'nacionality' => 'v',
              'birthdate' => '1992-10-07',
              'gender' => 'm',
              'address' => 'Caracas Catia',
              'phone' => '04143723172',
              'type_user' => 1
            ),
            array(
              'email' => 'jefe@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 2222222,
              'first_name' => 'N Jefe',
              'last_name' => 'A Jefe',
              'place_birth' => 'Caracas',
              'nacionality' => 'v',
              'birthdate' => '1992-10-07',
              'gender' => 'm',
              'address' => 'Caracas Catia',
              'phone' => '04143723172',
              'type_user' => 2
            ),
            array(
              'email' => 'operador@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 3333333,
              'first_name' => 'N Operador',
              'last_name' => 'A Operador',
              'place_birth' => 'Caracas',
              'nacionality' => 'v',
              'birthdate' => '1992-10-07',
              'gender' => 'm',
              'address' => 'Caracas Catia',
              'phone' => '04143723172',
              'type_user' => 3
            ),
            array(
              'email' => 'solicitante@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 4444444,
              'first_name' => 'N Solicitante',
              'last_name' => 'A Solicitante',
              'place_birth' => 'Caracas',
              'nacionality' => 'v',
              'birthdate' => '1992-10-07',
              'gender' => 'm',
              'address' => 'Caracas Catia',
              'phone' => '04143723172',
              'type_user' => 4
            )
        );
      DB::table('users')->insert($dataAdmins);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
