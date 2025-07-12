<?php

declare(strict_types=1);

namespace App\Models\Pieces\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class PieceWithScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->with([
            'type',
            'status',
            'pov',
            'tense',
            'genre',
            'subGenre',
            'tone',
            'theme',
            'character',
            'pace',
            'setting',
            'timeline',
            'storyline',
            'style',
        ]);
    }
}
