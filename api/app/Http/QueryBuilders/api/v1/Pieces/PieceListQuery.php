<?php

namespace App\Http\QueryBuilders\api\v1\Pieces;

use App\Http\QueryBuilders\api\v1\Filters\DateFilter;
use App\Http\QueryBuilders\api\v1\Filters\FuzzyFilter;
use App\Http\Requests\api\v1\Pieces\PieceListRequest;
use App\Models\Piece;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PieceListQuery extends QueryBuilder
{
    public function __construct(PieceListRequest $request)
    {
        $builder = Piece::query()
            ->where('user_id', auth()->id())
            ->with(['pieceType', 'pieceStatus']);

        parent::__construct($builder, $request);

        $this->allowedSorts(
            'piece_type_id',
            'piece_status_id',
            'start_date',
            'completion_date',
            'created_at',
            'updated_at',
        )
        ->allowedFilters(
            AllowedFilter::exact('status', 'piece_status_id'),
            AllowedFilter::exact('type', 'piece_type_id'),
            AllowedFilter::custom('search', new FuzzyFilter('title', 'synopsis')),
            AllowedFilter::custom('created_at', new DateFilter),
            AllowedFilter::custom('start_date', new DateFilter),
            AllowedFilter::custom('completion_date', new DateFilter),
        );
    }
}
