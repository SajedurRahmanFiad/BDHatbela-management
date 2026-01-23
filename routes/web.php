<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/**
 * 'web' middleware applied to all routes
 *
 * @see \App\Providers\Route::mapWebRoutes
 */

 Livewire::setScriptRoute(function ($handle) {
    $base = request()->getBasePath();

    return Route::get($base . '/vendor/livewire/livewire/dist/livewire.min.js', $handle);
});

// CarryBee proxy fallback (bypass external CORS when running locally)
Route::get('api/carrybee/cities', 'Api\Document\Documents@getCarryBeeCities')->name('carrybee.cities.proxy');
Route::get('api/carrybee/cities/{city_id}/zones', 'Api\Document\Documents@getCarryBeeZones')->name('carrybee.zones.proxy');
