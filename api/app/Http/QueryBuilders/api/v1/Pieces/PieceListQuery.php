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
            AllowedSort::field('type', 'piece_type_id'),
            AllowedSort::field('status', 'piece_status_id'),
            AllowedSort::field('pov', 'piece_pov_id'),
            AllowedSort::field('tense', 'piece_tense_id'),
            AllowedSort::field('genre', 'piece_genre_id'),
            AllowedSort::field('sub_genre', 'piece_sub_genre_id'),
            AllowedSort::field('tone', 'piece_tone_id'),
            AllowedSort::field('theme', 'piece_theme_id'),
            AllowedSort::field('started', 'start_date'),
            AllowedSort::field('completed', 'completion_date'),
            AllowedSort::field('created', 'created_at'),
            AllowedSort::field('updated', 'updated_at'),
        )
        ->allowedFilters(
            // TODO: See how to filter by child relationships in the Spatie QueryBuilder
            AllowedFilter::exact('status', 'piece_status_id'),
            AllowedFilter::exact('type', 'piece_type_id'),
            AllowedFilter::exact('pov', 'piece_pov_id'),
            AllowedFilter::exact('tense', 'piece_tense_id'),
            AllowedFilter::exact('genre', 'piece_genre_id'),
            AllowedFilter::exact('sub_genre', 'piece_sub_genre_id'),
            AllowedFilter::exact('tone', 'piece_tone_id'),
            AllowedFilter::exact('theme', 'piece_theme_id'),
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
