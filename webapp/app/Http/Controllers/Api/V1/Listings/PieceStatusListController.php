<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\PieceStatusesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PieceStatusListController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceStatusesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Statuses',
            $action->handle()
        );
    }
}
