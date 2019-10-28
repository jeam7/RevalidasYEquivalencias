<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/home', function () {
    return redirect('/admin/dashboard');
});

Route::get('/admin/register', 'Admin\RegisterController@showRegistrationForm')->name('backpack.auth.register');
Route::post('/admin/register', 'Admin\RegisterController@register');

Route::get('/admin/registerStep2', 'Admin\RegisterController@showRegistrationFormStep2');
Route::post('/admin/registerStep2', 'Admin\RegisterController@registerStep2');

Route::get('/admin/successSendRegisterMail', function(){
  return view('successSendRegisterMail');
});

Route::get('/admin/successRegisterUser', function(){
  return view('successRegisterUser');
});
