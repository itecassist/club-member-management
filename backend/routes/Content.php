<?php

use App\Http\Controllers\Content\ArticleController;
use App\Http\Controllers\Content\FaqController;


Route::apiResource('articles', ArticleController::class);

Route::apiResource('faqs', FaqController::class);
