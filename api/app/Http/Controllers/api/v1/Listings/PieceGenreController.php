<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PieceGenresListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PieceGenreController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceGenresListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Genres',
            $action->handle()
        );
    }
}
