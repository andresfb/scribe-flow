<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Pace;

final readonly class PacesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Pace::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
