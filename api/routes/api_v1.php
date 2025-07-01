<?php

use App\Http\Controllers\api\v1\Listings\PiecePovController;
use App\Http\Controllers\api\v1\Listings\PieceStatusListController;
use App\Http\Controllers\api\v1\Listings\PieceTenseController;
use App\Http\Controllers\api\v1\Listings\PieceTypeListController;
use App\Http\Controllers\api\v1\Pieces\PieceController;
use App\Http\Controllers\api\v1\Users\UserController;
use Illuminate\Http\Request;

Route::middleware(['auth:sanctum'])
    ->group(static function () {

        Route::post('/test', static function (Request $request) {
            $request->validate([
                'name' => 'required|string',
            ]);

            return response()->json([
                'message' => 'Hello my baby, hello my honey, hello my sweet '.$request->input('name')
            ]);
        });

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('user.show');

        Route::get('/piece-types/list', PieceTypeListController::class)
            ->name('piece-types.list');

        Route::get('/piece-statuses/list', PieceStatusListController::class)
            ->name('piece-statuses.list');

        Route::get('/piece-povs/list', PiecePovController::class)
            ->name('piece-povs.list');

        Route::get('/piece-tenses/list', PieceTenseController::class)
            ->name('piece-tenses.list');

        Route::resource('/pieces', PieceController::class, [
            'except' => ['edit', 'create']
        ]);

    });
