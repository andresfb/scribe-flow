<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Genre;

final readonly class GenresListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Genre::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
