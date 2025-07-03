<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PieceGenre;

final readonly class PieceGenresListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceGenre::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
