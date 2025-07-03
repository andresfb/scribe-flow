<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PieceTone;

final readonly class PieceTonesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceTone::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
