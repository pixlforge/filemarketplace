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
 * Marketplace
 */
Route::prefix('/account/connect')->namespace('Account')->group(function () {
    Route::get('/', 'MarketplaceConnectController@index')->name('account.connect');
    Route::get('/complete', 'MarketplaceConnectController@store')->name('account.complete');
});


/**
 * Account
 */
Route::prefix('/account')->namespace('Account')->middleware(['auth', 'needs.marketplace'])->group(function () {
    Route::get('/', 'AccountController@index')->name('account');

    /**
     * Files
     */
    Route::prefix('/files')->group(function () {
        Route::get('/', 'FilesController@index')->name('account.files.index');
        Route::get('/create', 'FilesController@create')->name('account.files.create.start');
        Route::get('/{file}/create', 'FilesController@create')->name('account.files.create.finish');
        Route::post('/{file}', 'FilesController@store')->name('account.files.store');
        Route::get('/{file}/edit', 'FilesController@edit')->name('account.files.edit');
        Route::patch('/{file}', 'FilesController@update')->name('account.files.update');
    });
});

/**
 * Admin
 */
Route::prefix('/admin')->namespace('Admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/{file}', 'FileController@show')->name('admin.files.show');

    /**
     * File New
     */
    Route::prefix('/files')->group(function () {
        Route::prefix('/new')->group(function () {
            Route::get('/', 'FileNewController@index')->name('admin.files.new.index');
            Route::patch('/{file}', 'FileNewController@update')->name('admin.files.new.update');
            Route::delete('/{file}', 'FileNewController@destroy')->name('admin.files.new.destroy');
        });
    });

    /**
     * File Updated
     */
    Route::prefix('/files')->group(function () {
        Route::prefix('/updated')->group(function () {
            Route::get('/', 'FileUpdatedController@index')->name('admin.files.updated.index');
            Route::patch('/{file}', 'FileUpdatedController@update')->name('admin.files.updated.update');
            Route::delete('/{file}', 'FileUpdatedController@destroy')->name('admin.files.updated.destroy');
        });
    });
});

/**
 * Upload
 */
Route::post('/{file}/upload', 'Upload\UploadController@store')->name('upload.store');
Route::delete('/{file}/upload/{upload}', 'Upload\UploadController@destroy')->name('upload.destroy');

Route::get('/{file}', 'Files\FileController@show')->name('files.show');

/**
 * Checkout
 */
Route::prefix('/{file}/checkout')->namespace('Checkout')->group(function () {
    Route::post('/free', 'CheckoutController@free')->name('checkout.free');
    Route::post('/payment', 'CheckoutController@payment')->name('checkout.payment');
});

/**
 * Download
 */
Route::get('/{file}/{sale}/download', 'Files\DownloadController@show')->name('files.download');