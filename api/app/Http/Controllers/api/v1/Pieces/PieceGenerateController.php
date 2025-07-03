<?php

namespace App\Http\Controllers\api\v1\Pieces;

use App\Actions\Pieces\PieceGenerateAction;
use App\Dtos\Pieces\PieceStoreItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Pieces\PieceRequest;
use App\Models\Pieces\Piece;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Throwable;

class PieceGenerateController extends Controller
{
    use AuthorizesRequests;
    use ApiResponses;

    public function __invoke(PieceRequest $request, PieceGenerateAction $action): JsonResponse
    {
        try {
            $this->authorize('create', Piece::class);

            $jobId = $action->handle(
                PieceStoreItem::from($request),
                auth()->id()
            );

            return $this->ok(
                message: 'Generate Request accepted',
                data: ['job_id' => $jobId],
            );
        } catch (Throwable $e) {
            return $this->error(
                message: $e->getMessage(),
                status: (int) $e->getCode(),
            );
        }
    }
}
