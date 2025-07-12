<?php

declare(strict_types=1);

use App\Http\Controllers\Api\SanctumTokenController;

Route::post('/api/sanctum/token', SanctumTokenController::class);
