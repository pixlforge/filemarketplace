<?php

/**
 * Root
 */
Route::get('/', 'HomeController@index')->name('home');

/**
 * Authentication
 */
Auth::routes();

/**
 * Account
 */
Route::prefix('/account')
    ->namespace('Account')
    ->middleware('auth')
    ->group(function () {
    Route::get('/', 'AccountController@index')->name('account');

    Route::prefix('/files')->group(function () {
        Route::get('/', 'FilesController@index')->name('account.files.index');
        Route::get('/create', 'FilesController@create')->name('account.files.create.start');
        Route::get('/{file}/create', 'FilesController@create')->name('account.files.create.finish');
        Route::post('/{file}', 'FilesController@store')->name('account.files.store');
        Route::get('/{file}/edit', 'FilesController@edit')->name('account.files.edit');
        Route::patch('/{file}', 'FilesController@update')->name('account.files.update');
    });
});

Route::post('/{file}/upload', 'Upload\UploadController@store')->name('upload.store');
Route::delete('/{file}/upload/{upload}', 'Upload\UploadController@destroy')->name('upload.destroy');
