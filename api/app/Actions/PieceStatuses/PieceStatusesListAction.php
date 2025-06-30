<?php

declare(strict_types=1);

namespace App\Actions\PieceStatuses;

use App\Models\PieceStatus;

final readonly class PieceStatusesListAction
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return PieceStatus::query()
            ->where('active', true)
            ->orderBy('order')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
