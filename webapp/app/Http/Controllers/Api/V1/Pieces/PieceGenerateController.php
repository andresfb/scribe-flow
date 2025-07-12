<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Pieces;

use App\Actions\Pieces\PieceGenerateFullAction;
use App\Actions\Pieces\PieceGeneratePartialAction;
use App\Dtos\Pieces\PieceItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pieces\PieceCreateRequest;
use App\Http\Requests\Pieces\PieceGenerateFullRequest;
use App\Http\Resources\Api\V1\Pieces\PieceResource;
use App\Models\Pieces\Piece;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Throwable;

final class PieceGenerateController extends Controller
{
    use ApiResponses;
    use AuthorizesRequests;

    public function partial(PieceCreateRequest $request, PieceGeneratePartialAction $action): PieceResource|JsonResponse
    {
        try {
            $this->authorize('create', Piece::class);

            return new PieceResource(
                $action->handle(
                    PieceItem::from($request),
                    auth()->id(),
                )
            );
        } catch (Throwable $e) {
            return $this->error(
                message: $e->getMessage(),
                status: (int) $e->getCode(),
            );
        }
    }

    public function full(PieceGenerateFullRequest $request, PieceGenerateFullAction $action): JsonResponse
    {
        try {
            $this->authorize('create', Piece::class);

            $jobId = $action->handle(
                PieceItem::from($request),
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
