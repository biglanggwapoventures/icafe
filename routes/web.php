<?php

/**
 * Routes for web login
 */
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
});

/**
 * Logout route
 */
Route::post('logout', 'Auth\LoginController@logout')->middleware('auth');

/**
 * Social media logins
 */
Route::group(['prefix' => 'login', 'namespace' => 'Auth', 'as' => 'login.', 'middleware' => 'guest'], function () {
    Route::group(['prefix' => 'google'], function () {
        Route::get('/', 'GoogleLoginController@redirectToProvider')->name('google');
        Route::get('callback', 'GoogleLoginController@handleProviderCallback');
    });
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('/', 'FacebookLoginController@redirectToProvider')->name('facebook');
        Route::get('callback', 'FacebookLoginController@handleProviderCallback');
    });
});

/**
 * Super admin routes
 */
Route::group(['namespace' => 'SuperAdmin', 'as' => 'super-admin.', 'prefix' => 'super-admin', 'middleware' => 'auth'], function () {
    Route::view('/', 'super-admin.layout');
    Route::resource('cafe', 'CafeController');
    Route::resource('cafe-admin', 'CafeAdminController');
});

/**
 * Cafe admin routes
 */
Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::view('/', 'admin.layout');
});

/**
 * Standard user routes
 */
Route::group(['namespace' => 'User', 'prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController');
});

/**
 * Route for updating profile
 */
Route::post('update-profile', 'UpdateProfileController');
