<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PiecePov;

final readonly class PiecePovListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PiecePov::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
