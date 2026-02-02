<?php

use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\RoleController;


Route::apiResource('permissions', PermissionController::class);

Route::apiResource('roles', RoleController::class);
