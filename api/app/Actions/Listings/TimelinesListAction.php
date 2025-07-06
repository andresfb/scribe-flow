<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Timeline;

final readonly class TimelinesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Timeline::query()
            ->where('active', true)
            ->orderBy('weight', 'desc')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
