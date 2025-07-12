<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Style;

final readonly class StylesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Style::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
