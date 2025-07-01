<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\PieceTense;

final readonly class PieceTenseListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceTense::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
