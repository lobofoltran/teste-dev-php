<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('v1')
    ->group(base_path('routes/api_v1.php'));
