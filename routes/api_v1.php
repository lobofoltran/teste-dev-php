<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SupplierController;

Route::apiResource('suppliers', SupplierController::class);
