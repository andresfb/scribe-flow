<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PieceTonesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PieceToneController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceTonesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Tones',
            $action->handle()
        );
    }
}
