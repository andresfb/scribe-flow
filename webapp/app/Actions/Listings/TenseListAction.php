<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Tense;

final readonly class TenseListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Tense::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
