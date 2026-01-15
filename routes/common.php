<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/**
 * 'common' middleware applied to all routes
 *
 * @see \App\Providers\Route::mapCommonRoutes
 */

Route::group(['middleware' => 'auth'], function () {
    Route::group(['as' => 'uploads.', 'prefix' => 'uploads'], function () {
        Route::get('{id}', 'Common\Uploads@get')->name('get');
        Route::get('{id}/show', 'Common\Uploads@show')->name('show');
        Route::get('{id}/download', 'Common\Uploads@download')->name('download');
    });

    // Dashboard route: use the admin menu, actual access is enforced in the controller
    // via the read-common-dashboards permission middleware. This avoids double
    // permission checks that can cause unexpected 403s for limited roles such as employees.
    Route::group(['middleware' => ['menu.admin']], function () {
        Route::get('/', 'Common\\Dashboards@show')->name('dashboard');
    });

    // Other admin-only routes still require full admin-panel permission
    Route::group(['middleware' => ['permission:read-admin-panel']], function () {
        Route::get('wizard', 'Wizard\Companies@edit')->name('wizard.edit');
    });

    Route::group(['middleware' => ['menu.portal', 'permission:read-client-portal']], function () {
        Route::get('portal', 'Portal\Dashboard@index')->name('portal.dashboard');
    });
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle);
});
