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


// Route::get('/admin', function () {
//     return redirect('/admin/sent_record');
// });
//
// Route::get('/admin/dashboard', function () {
//     return redirect('/admin/sent_record');
// });
//
// Route::get('/admin/password/reset', function () {
//     return redirect('/');
// });
