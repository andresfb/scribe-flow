<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PieceType;

final readonly class PieceTypeListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceType::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
