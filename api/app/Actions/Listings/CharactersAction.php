<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Character;

final readonly class CharactersAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Character::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
