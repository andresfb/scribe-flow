<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PiecePovListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PiecePovController extends Controller
{
    use ApiResponses;

    public function __invoke(PiecePovListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece POVs',
            $action->handle()
        );
    }
}
