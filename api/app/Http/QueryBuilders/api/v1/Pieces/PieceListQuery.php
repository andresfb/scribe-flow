<?php

namespace App\Http\QueryBuilders\api\v1\Pieces;

use App\Http\QueryBuilders\api\v1\Filters\DateFilter;
use App\Http\QueryBuilders\api\v1\Filters\FuzzyFilter;
use App\Http\Requests\api\v1\Pieces\PieceListRequest;
use App\Models\Pieces\Piece;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PieceListQuery extends QueryBuilder
{
    public function __construct(PieceListRequest $request)
    {
        $builder = Piece::query()
            ->where('user_id', auth()->id());

        parent::__construct($builder, $request);

        $this->allowedSorts(
            'piece_type_id',
            'piece_status_id',
            'piece_pov_id',
            'piece_tense_id',
            'genre',
            'sub_genre',
            'start_date',
            'completion_date',
            'created_at',
            'updated_at',
        )
        ->allowedFilters(
            AllowedFilter::exact('status', 'piece_status_id'),
            AllowedFilter::exact('type', 'piece_type_id'),
            AllowedFilter::exact('pov', 'piece_pov_id'),
            AllowedFilter::exact('tense', 'piece_tense_id'),
            AllowedFilter::partial('genre'),
            AllowedFilter::partial('sub_genre'),
            AllowedFilter::partial('setting_time_period'),
            AllowedFilter::partial('setting_location'),
            AllowedFilter::custom(
                'search',
                new FuzzyFilter(
                    'title',
                    'synopsis',
                    'genre',
                    'sub_genre',
                    'setting_time_period',
                    'setting_location'
                )
            ),
            AllowedFilter::custom('created_at', new DateFilter),
            AllowedFilter::custom('start_date', new DateFilter),
            AllowedFilter::custom('completion_date', new DateFilter),
        );
    }

    public function loadRelationship(?string $relationship): self
    {
        if (blank($relationship)) {
            return $this;
        }

        $this->subject->with($relationship);

        return $this;
    }
}
