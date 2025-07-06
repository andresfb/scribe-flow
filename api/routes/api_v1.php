<?php

declare(strict_types=1);

use App\Http\Controllers\api\v1\Listings\CharacterController;
use App\Http\Controllers\api\v1\Listings\GenreController;
use App\Http\Controllers\api\v1\Listings\PaceController;
use App\Http\Controllers\api\v1\Listings\PovController;
use App\Http\Controllers\api\v1\Listings\PieceStatusListController;
use App\Http\Controllers\api\v1\Listings\SettingController;
use App\Http\Controllers\api\v1\Listings\StorylineController;
use App\Http\Controllers\api\v1\Listings\StyleController;
use App\Http\Controllers\api\v1\Listings\TenseController;
use App\Http\Controllers\api\v1\Listings\ThemeController;
use App\Http\Controllers\api\v1\Listings\TimelineController;
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

        Route::get('/timelines/list', TimelineController::class)
            ->name('timelines.list');

        Route::get('/settings/list', SettingController::class)
            ->name('settings.list');

        Route::get('/storylines/list', StorylineController::class)
            ->name('storylines.list');

        Route::get('/styles/list', StyleController::class)
            ->name('styles.list');

        Route::get('/piece-types/list', PieceTypeListController::class)
            ->name('piece-types.list');

        Route::get('/piece-statuses/list', PieceStatusListController::class)
            ->name('piece-statuses.list');

        Route::resource('/pieces', PieceController::class, [
            'except' => ['edit'],
        ]);

        Route::put('/pieces/generate/full', [PieceGenerateController::class, 'full'])
            ->name('pieces.generate.full');

        Route::put('/pieces/generate/partial', [PieceGenerateController::class, 'partial'])
            ->name('pieces.generate.partial');

    });
