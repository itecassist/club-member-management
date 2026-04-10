<?php

use App\Http\Controllers\Shared\CountryController;


Route::apiResource('countries', CountryController::class);

Route::apiResource('countrys', CountryController::class);
