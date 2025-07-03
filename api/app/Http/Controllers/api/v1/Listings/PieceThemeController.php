<?php

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PieceThemesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class PieceThemeController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceThemesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Tones',
            $action->handle()
        );
    }
}
