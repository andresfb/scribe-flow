<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;

final readonly class LoadUserAction
{
    public function handle(int $userId, array $includes): User
    {
        return User::where('id', $userId)
            ->with([
                'tokens',
                'notifications',
                'readNotifications',
                'unreadNotifications',
            ])
            ->with($includes)
            ->firstOrFail();
    }
}
