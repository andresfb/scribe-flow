<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Models\Pieces\Piece;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class PieceDeleteAction
{
    public function __construct(public PieceGetAction $getAction) {}

    /**
     * @throws Throwable
     */
    public function handle(Piece $model): void
    {
        DB::transaction(static function () use ($model): void {
            $model->syncTags([]);

            // TODO: delete any extra child records

            $model->delete();
        });
    }
}
