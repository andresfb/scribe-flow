<?php

namespace App\Http\Controllers\api\v1\Pieces;

use App\Http\Controllers\Controller;
use App\Http\QueryBuilders\api\v1\Pieces\PieceListQuery;
use App\Http\Requests\api\v1\Pieces\PieceListRequest;
use App\Http\Requests\api\v1\Pieces\PieceRequest;
use App\Http\Resources\api\v1\Pieces\PieceResource;
use App\Models\Piece;
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
            $query->with($this->include('user') ? 'user' : '')
                ->paginate()
                ->appends($request->query())
        );
    }

    public function store(PieceRequest $request): PieceResource
    {
        $this->authorize('create', Piece::class);

        return new PieceResource(Piece::create($request->validated()));
    }

    public function show(Piece $piece): PieceResource
    {
        $this->authorize('view', $piece);

        return new PieceResource($piece);
    }

    public function update(PieceRequest $request, Piece $piece): PieceResource
    {
        $this->authorize('update', $piece);

        $piece->update($request->validated());

        return new PieceResource($piece);
    }

    public function destroy(Piece $piece): JsonResponse
    {
        $this->authorize('delete', $piece);

        $piece->delete();

        return $this->ok('Piece deleted');
    }
}
