<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('organizations')->controller(OrganizationController::class)->group(function () {
    Route::get('/by-building/{building}', 'getByBuilding');
    Route::get('/by-activity/{activity}', 'getByActivity');
    Route::get('/by-id/{organization}', 'getById');
    Route::get('/by-map/radius', 'getByMapRadius');
    Route::get('/by-map/rectangle', 'getByMapRectangle');
    Route::get('/by-activity-tree/{activity}', 'getByActivityTree');
    Route::get('/by-name/{name}', 'getByName');
});
