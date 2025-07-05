<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Lists\Theme;

final readonly class ThemesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Theme::query()
            ->where('active', true)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
