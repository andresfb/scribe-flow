<?php

//use App\Http\Controllers\Api\V1\UserController;

use Illuminate\Http\Request;

Route::middleware(['auth:sanctum', 'throttle:api'])
    ->group(static function () {

        Route::post('/test', static function (Request $request) {
            $request->validate([
                'name' => 'required|string',
            ]);

            return response()->json([
                'message' => 'Hello, '.$request->input('name')
            ]);
        });

//        Route::get('/users/{user}', [UserController::class, 'show'])
//            ->name('user.show');

    });
