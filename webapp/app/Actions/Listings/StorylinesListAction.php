<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Storyline;

final readonly class StorylinesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Storyline::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
