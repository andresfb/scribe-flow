<?php

namespace App\Http\QueryBuilders\api\v1\Pieces;

use App\Http\QueryBuilders\api\v1\Filters\DateFilter;
use App\Http\QueryBuilders\api\v1\Filters\FuzzyFilter;
use App\Http\Requests\api\v1\Pieces\PieceListRequest;
use App\Models\Pieces\Piece;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class PieceListQuery extends QueryBuilder
{
    public function __construct(PieceListRequest $request)
    {
        $builder = Piece::query()
            ->where('user_id', auth()->id());

        parent::__construct($builder, $request);

        $this->allowedSorts(
            AllowedSort::field('genre'),
            AllowedSort::field('sub_genre'),
            AllowedSort::field('type', 'piece_type_id'),
            AllowedSort::field('status', 'piece_status_id'),
            AllowedSort::field('pov', 'piece_pov_id'),
            AllowedSort::field('tense', 'piece_tense_id'),
            AllowedSort::field('started', 'start_date'),
            AllowedSort::field('completed', 'completion_date'),
            AllowedSort::field('created', 'created_at'),
            AllowedSort::field('updated', 'updated_at'),
        )
        ->allowedFilters(
            AllowedFilter::exact('status', 'piece_status_id'),
            AllowedFilter::exact('type', 'piece_type_id'),
            AllowedFilter::exact('pov', 'piece_pov_id'),
            AllowedFilter::exact('tense', 'piece_tense_id'),
            AllowedFilter::partial('genre'),
            AllowedFilter::partial('sub_genre'),
            AllowedFilter::partial('period', 'setting_time_period'),
            AllowedFilter::partial('location', 'setting_location'),
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
            AllowedFilter::custom('created', new DateFilter),
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
