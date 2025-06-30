<?php

use App\Http\Controllers\api\v1\Pieces\PieceController;
use App\Http\Controllers\api\v1\PieceStatuses\PieceStatusListController;
use App\Http\Controllers\api\v1\PieceTypes\PieceTypeListController;
use App\Http\Controllers\api\v1\Users\UserController;
use Illuminate\Http\Request;

Route::middleware(['auth:sanctum'])
    ->group(static function () {

        Route::post('/test', static function (Request $request) {
            $request->validate([
                'name' => 'required|string',
            ]);

            return response()->json([
                'message' => 'Hello, '.$request->input('name')
            ]);
        });

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('user.show');

        Route::get('/piece-types/list', PieceTypeListController::class)
            ->name('piece-types.list');

        Route::get('/piece-statuses/list', PieceStatusListController::class)
            ->name('piece-statuses.list');

        Route::resource('/pieces', PieceController::class, [
            'except' => ['edit', 'create']
        ]);

    });
