<?php

//use App\Http\Controllers\Api\V1\UserController;

Route::middleware(['auth:sanctum', 'throttle:api'])
    ->group(static function () {

//        Route::get('/users/{user}', [UserController::class, 'show'])
//            ->name('user.show');

});
