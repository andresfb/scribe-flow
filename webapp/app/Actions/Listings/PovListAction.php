<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Pov;

final readonly class PovListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Pov::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
