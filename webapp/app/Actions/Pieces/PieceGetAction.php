<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Models\Pieces\Piece;

final readonly class PieceGetAction
{
    /**
     * Execute the action.
     */
    public function handle(string $slug, int $userId): Piece
    {
        return Piece::where('slug', $slug)
            ->where('user_id', $userId)
            ->with('tags')
            ->firstOrFail();
    }
}
