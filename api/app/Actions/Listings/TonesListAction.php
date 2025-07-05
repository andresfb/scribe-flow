<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Tone;

final readonly class TonesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Tone::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
