<?php

use App\Http\Controllers\Financial\InvoiceController;
use App\Http\Controllers\Financial\PaymentController;
use App\Http\Controllers\Financial\AccountBalanceController;


Route::apiResource('invoices', InvoiceController::class);

Route::apiResource('payments', PaymentController::class);

Route::apiResource('accountbalances', AccountBalanceController::class);
