<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'places',
], function () {
    Route::get('all', [\App\Http\Controllers\Api\PlacesController::class, 'all']);
    Route::get('list_by_range', [\App\Http\Controllers\Api\PlacesController::class, 'placesListByRange']);
});
