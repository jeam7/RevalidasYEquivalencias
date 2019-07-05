<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('user', 'UserCrudController');
    if (config('backpack.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('backpack.account.info');
        Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm');
        Route::get('change-password', 'MyAccountController@getChangePasswordForm')->name('backpack.account.password');
        Route::post('change-password', 'MyAccountController@postChangePasswordForm');

        // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
        // Route::post('register', 'Auth\RegisterController@register');
    }
    CRUD::resource('college', 'CollegeCrudController');
    CRUD::resource('faculty', 'FacultyCrudController');
    CRUD::resource('school', 'SchoolCrudController');
    CRUD::resource('career', 'CareerCrudController');
    CRUD::resource('subject', 'SubjectCrudController');
    CRUD::resource('academic_period', 'Academic_periodCrudController');
    CRUD::resource('request', 'RequestCrudController')->with(function(){
      Route::get('request/generarPdfSolicitud/{id}', 'RequestCrudController@generarPdfSolicitud');
    });
    CRUD::resource('myrequest', 'MyRequestCrudController');
    // CRUD::resource('voucher', 'VoucherCrudController');
    CRUD::resource('voucher', 'VoucherCrudController')->with(function(){
      Route::get('voucher/getSubjectsOrigin/{id}', 'VoucherCrudController@getSubjectsOrigin');
      Route::get('voucher/getSubjectsDestination/{id}', 'VoucherCrudController@getSubjectsDestination');
      Route::post('voucher/createEquivalentSubject', 'VoucherCrudController@createEquivalentSubject');
      Route::get('voucher/getEquivalentSubject/{id}', 'VoucherCrudController@getEquivalentSubject');
      Route::post('voucher/deleteEquivalentSubject', 'VoucherCrudController@deleteEquivalentSubject');
      Route::get('voucher/generarPdfComprobante/{id}', 'VoucherCrudController@generarPdfComprobante');
    });
    // CRUD::resource('equivalent_subject', 'Equivalent_subjectCrudController');
}); // this should be the absolute last line of this file
