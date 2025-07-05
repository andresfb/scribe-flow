<?php

declare(strict_types=1);

use App\Http\Controllers\api\v1\Listings\CharacterController;
use App\Http\Controllers\api\v1\Listings\GenreController;
use App\Http\Controllers\api\v1\Listings\PaceController;
use App\Http\Controllers\api\v1\Listings\PovController;
use App\Http\Controllers\api\v1\Listings\PieceStatusListController;
use App\Http\Controllers\api\v1\Listings\SettingController;
use App\Http\Controllers\api\v1\Listings\TenseController;
use App\Http\Controllers\api\v1\Listings\ThemeController;
use App\Http\Controllers\api\v1\Listings\ToneController;
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

        Route::get('/povs/list', PovController::class)
            ->name('povs.list');

        Route::get('/tenses/list', TenseController::class)
            ->name('tenses.list');

        Route::get('/genres/list', GenreController::class)
            ->name('genres.list');

        Route::get('/tones/list', ToneController::class)
            ->name('tones.list');

        Route::get('/themes/list', ThemeController::class)
            ->name('themes.list');

        Route::get('/characters/list', CharacterController::class)
            ->name('characters.list');

        Route::get('/paces/list', PaceController::class)
            ->name('paces.list');

        Route::get('/settings/list', SettingController::class)
            ->name('settings.list');

        Route::get('/piece-types/list', PieceTypeListController::class)
            ->name('piece-types.list');

        Route::get('/piece-statuses/list', PieceStatusListController::class)
            ->name('piece-statuses.list');

        Route::resource('/pieces', PieceController::class, [
            'except' => ['edit'],
        ]);

        Route::put('/pieces/generate', PieceGenerateController::class)
            ->name('pieces.generate');

    });
