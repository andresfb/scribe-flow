<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\PieceTypeListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PieceTypeListController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceTypeListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Types',
            $action->handle()
        );
    }
}
