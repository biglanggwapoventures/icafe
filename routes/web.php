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
Route::group(['namespace' => 'SuperAdmin', 'as' => 'super-admin.', 'prefix' => 'super-admin', 'middleware' => 'auth:superadmin'], function () {
    Route::view('/', 'super-admin.layout');
    Route::resource('cafe', 'CafeController');
    Route::resource('cafe-admin', 'CafeAdminController');
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('top-cafes', 'ReportsController@topCafes')->name('top-cafes');
        Route::get('credit-points-list', 'ReportsController@creditPointsList')->name('credit-points-list');
        Route::get('personal-usage-history', 'ReportsController@personalUsageHistory')->name('personal-usage-history');
    });
});

/**
 * Cafe admin routes
 */
Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::view('/', 'admin.layout');
    Route::get('floor-layout', 'FloorLayoutController@index')->name('floor-layout');
    Route::post('floor-layout', 'FloorLayoutController@store')->name('floor-layout.create');
    Route::patch('floor-layout', 'FloorLayoutController@update')->name('floor-layout.update');
    Route::resource('purchase-credits', 'PurchaseCreditsController');
    Route::group(['prefix' => 'reservations', 'as' => 'reservation.'], function () {
        Route::get('/', 'ReservationsController@index')->name('index');
    });
});

/**
 * Standard user routes
 */
Route::group(['namespace' => 'User', 'prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth:user'], function () {
    Route::get('/', 'DashboardController');
    Route::group(['prefix' => 'cafe/{cafeBranchId}', 'as' => 'cafe.'], function () {
        Route::get('/', 'FloorLayoutController@index')->name('view');
        Route::post('/', 'FloorLayoutController@reserve')->name('reserve');
    });
    Route::get('credit-history', 'CreditHistoryController')->name('credit-history');
    Route::get('reservation-history', 'ReservationHistoryController')->name('reservation-history');

});

/**
 * Miscellaneous routes
 */
Route::group(['middleware' => 'auth'], function () {
    /**
     * Update profile
     */
    Route::post('update-profile', 'UpdateProfileController')->middleware('auth');

    /**
     * Get today's reservation for a pc
     */
    Route::get('pc/{pc}/todays-reservations', 'GetTodaysReservationsController')->name('pc-reservations')->middleware('auth');
});
