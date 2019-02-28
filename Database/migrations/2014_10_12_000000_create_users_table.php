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
            $table->string('password');
            $table->integer('ci')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('place_birth');
            $table->enum('nacionality', ['v','e']);
            $table->date('birthdate');
            $table->enum('gender', ['m', 'f']);
            $table->string('address')->nullable();
            $table->string('phone');
            $table->enum('type_user',[1,2,3,4]);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        $dataAdmins = array(
            array(
              'email' => 'superadmin@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 1111111,
              'first_name' => 'Nombre Super Admin',
              'last_name' => 'Apellido Super Admin',
              'place_birth' => 'Caracas',
              'nacionality' => 'v',
              'birthdate' => '1992-10-07',
              'gender' => 'm',
              'address' => 'Caracas Catia',
              'phone' => '04143723172',
              'type_user' => 1
            ),
            array(
              'email' => 'jean@gmail.com',
              'password' => '$2a$10$XgHENPJMF8Ni5YGnTQrWFukPxqq8tOJUqfK5eGADuyzdDQXejlLvO',
              'ci' => 2222222,
              'first_name' => 'Jean',
              'last_name' => 'Akchar',
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
