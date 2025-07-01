<?php

namespace App\Http\Controllers\api\v1\Pieces;

use App\Actions\Pieces\PieceGetAction;
use App\Http\Controllers\Controller;
use App\Http\QueryBuilders\api\v1\Pieces\PieceListQuery;
use App\Http\Requests\api\v1\Pieces\PieceListRequest;
use App\Http\Requests\api\v1\Pieces\PieceRequest;
use App\Http\Resources\api\v1\Pieces\PieceResource;
use App\Models\Pieces\Piece;
use App\Traits\ApiResponses;
use App\Traits\RelationshipIncluder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PieceController extends Controller
{
    use AuthorizesRequests;
    use ApiResponses;
    use RelationshipIncluder;

    public function index(PieceListRequest $request, PieceListQuery $query): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Piece::class);

        return PieceResource::collection(
            $query->loadRelationship($this->include('tags') ? 'tags' : null)
                ->paginate()
                ->appends($request->query())
        );
    }

    public function store(PieceRequest $request): PieceResource
    {
        $this->authorize('create', Piece::class);

        return new PieceResource(Piece::create($request->validated()));
    }

    public function show(string $piece, PieceGetAction $action): PieceResource
    {
        $model = $action->handle($piece);
        $this->authorize('view', $model);

        return new PieceResource($model);
    }

    public function update(PieceRequest $request, string $piece, PieceGetAction $action): PieceResource
    {
        $model = $action->handle($piece);
        $this->authorize('update', $model);
        $model->update($request->validated());

        return new PieceResource($model);
    }

    public function destroy(string $piece, PieceGetAction $action): JsonResponse
    {
        $model = $action->handle($piece);
        $this->authorize('delete', $piece);
        $model->delete();

        return $this->ok('Piece deleted');
    }
}
