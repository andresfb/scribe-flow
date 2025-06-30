<?php

namespace App\Http\Controllers\api\v1\PieceTypes;

use App\Actions\PieceTypes\PieceTypeListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class PieceTypeListController extends Controller
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
