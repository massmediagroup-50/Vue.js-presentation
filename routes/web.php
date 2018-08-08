<?php

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/firm/{firm}', 'FirmController@show')->name('public.profile');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', 'FirmProfileController@show')->name('profile');

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'FirmProfileController@show')->name('profile');
        Route::delete('/{firm}', 'FirmProfileController@deactivate')->name('profile.deactivate');
    });

    Route::group(['prefix' => 'api'], function() {
        Route::get('/profile', 'Api\FirmProfileController@show');
        Route::post('/profile', 'Api\FirmProfileController@update');

        Route::post('/addresses', 'Api\FirmProfileController@addAddress');
        Route::delete('/addresses/{id}', 'Api\FirmProfileController@removeAddress');

        Route::post('/employees', 'Api\FirmProfileController@addEmployee');
        Route::delete('/employees/{id}', 'Api\FirmProfileController@removeEmployee');
    });
});