<?php

namespace App\Models\Pieces\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PieceWithScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->with([
            'pieceType',
            'pieceStatus',
            'piecePov',
            'pieceTense',
        ]);
    }
}
