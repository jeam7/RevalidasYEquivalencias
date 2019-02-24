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
    }
    CRUD::resource('college', 'CollegeCrudController');
    CRUD::resource('faculty', 'FacultyCrudController');
    CRUD::resource('school', 'SchoolCrudController');
}); // this should be the absolute last line of this file