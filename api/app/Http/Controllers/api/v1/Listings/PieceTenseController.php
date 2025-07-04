<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PieceTenseListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PieceTenseController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceTenseListAction $action): JsonResponse
    {
        return $this->ok(
            'List Piece Tenses',
            $action->handle()
        );
    }
}
