<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use App\Models\Setting;

final readonly class SettingsListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Setting::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
