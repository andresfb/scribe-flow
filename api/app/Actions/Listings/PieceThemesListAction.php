<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PieceTheme;

final readonly class PieceThemesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceTheme::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
