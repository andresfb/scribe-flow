<?php

declare(strict_types=1);

namespace App\Actions\Listings;

use Spatie\Tags\Tag;

final readonly class TagsListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return Tag::query()
            ->orderBy('order_column')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
