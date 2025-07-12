<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Pieces;

use App\Actions\Pieces\PieceCreateAction;
use App\Actions\Pieces\PieceDeleteAction;
use App\Actions\Pieces\PieceGetAction;
use App\Actions\Pieces\PieceStoreAction;
use App\Actions\Pieces\PieceUpdateAction;
use App\Dtos\Pieces\PieceItem;
use App\Http\Controllers\Controller;
use App\Http\QueryBuilders\Pieces\PieceListQuery;
use App\Http\Requests\Pieces\PieceCreateRequest;
use App\Http\Requests\Pieces\PieceListRequest;
use App\Http\Requests\Pieces\PieceUpdateRequest;
use App\Http\Resources\Api\V1\Pieces\PieceResource;
use App\Models\Pieces\Piece;
use App\Traits\ApiResponses;
use App\Traits\RelationshipIncluder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

final class PieceController extends Controller
{
    use ApiResponses;
    use AuthorizesRequests;
    use RelationshipIncluder;

    public function index(
        PieceListRequest $request,
        PieceListQuery $query
    ): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Piece::class);

        return PieceResource::collection(
            $query->loadRelationship('tags')
                ->paginate()
                ->appends($request->query())
        );
    }

    public function create(PieceCreateAction $action): PieceResource
    {
        $this->authorize('create', Piece::class);
        $item = $action->handle(auth()->id());

        return (new PieceResource($item->piece))
            ->additional([
                'meta' => [
                    'types' => $item->types,
                    'statuses' => $item->statuses,
                    'povs' => $item->povs,
                    'tenses' => $item->tenses,
                    'genres' => $item->genres,
                    'tones' => $item->tones,
                    'themes' => $item->themes,
                    'tags' => $item->tags,
                ],
            ]);
    }

    public function store(
        PieceCreateRequest $request,
        PieceStoreAction $action
    ): PieceResource|JsonResponse
    {
        try {
            $this->authorize('create', Piece::class);

            return new PieceResource(
                $action->handle(
                    PieceItem::from($request),
                    auth()->id()
                )
            );
        } catch (Throwable $e) {
            return $this->error(
                message: $e->getMessage(),
                status: (int) $e->getCode(),
            );
        }
    }

    public function show(string $piece, PieceGetAction $action): PieceResource
    {
        $model = $action->handle($piece, auth()->id());
        $this->authorize('view', $model);

        return new PieceResource($model);
    }

    public function update(
        PieceUpdateRequest $request,
        string $piece,
        PieceUpdateAction $update
    ): PieceResource|JsonResponse
    {
        try {
            $model = $update->getAction
                ->handle($piece, auth()->id());

            $this->authorize('update', $model);

            $model = $update->handle($model, PieceItem::from($request));

            return new PieceResource($model);
        } catch (Throwable $e) {
            return $this->error(
                message: $e->getMessage(),
                status: (int) $e->getCode(),
            );
        }
    }

    public function destroy(string $piece, PieceDeleteAction $action): JsonResponse
    {
        try {
            $model = $action->getAction->handle($piece, auth()->id());

            $this->authorize('delete', $model);

            $action->handle($model);

            return $this->ok('Piece deleted successfully');
        } catch (Throwable $e) {
            return $this->error(
                message: $e->getMessage(),
                status: (int) $e->getCode(),
            );
        }
    }
}
