<?php

declare(strict_types=1);

use App\Http\Controllers\api\v1\Listings\PieceGenreController;
use App\Http\Controllers\api\v1\Listings\PiecePovController;
use App\Http\Controllers\api\v1\Listings\PieceStatusListController;
use App\Http\Controllers\api\v1\Listings\PieceTenseController;
use App\Http\Controllers\api\v1\Listings\PieceThemeController;
use App\Http\Controllers\api\v1\Listings\PieceToneController;
use App\Http\Controllers\api\v1\Listings\PieceTypeListController;
use App\Http\Controllers\api\v1\Pieces\PieceController;
use App\Http\Controllers\api\v1\Pieces\PieceGenerateController;
use App\Http\Controllers\api\v1\Users\UserController;
use Illuminate\Http\Request;

Route::middleware(['auth:sanctum'])
    ->group(static function (): void {

        Route::post('/test', static function (Request $request) {
            $request->validate([
                'name' => 'required|string',
            ]);

            return response()->json([
                'message' => 'Hello my baby, hello my honey, hello my sweet '.$request->input('name'),
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

        Route::get('/piece-genres/list', PieceGenreController::class)
            ->name('piece-genres.list');

        Route::get('/piece-tones/list', PieceToneController::class)
            ->name('piece-tones.list');

        Route::get('/piece-themes/list', PieceThemeController::class)
            ->name('piece-themes.list');

        Route::resource('/pieces', PieceController::class, [
            'except' => ['edit'],
        ]);

        Route::put('/pieces/generate', PieceGenerateController::class)
            ->name('pieces.generate');

    });
