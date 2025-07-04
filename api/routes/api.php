<?php

declare(strict_types=1);

use App\Http\Controllers\SanctumTokenController;

Route::post('/sanctum/token', SanctumTokenController::class);
