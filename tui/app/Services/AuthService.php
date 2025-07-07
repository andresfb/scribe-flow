<?php

namespace App\Services;

use App\Dtos\UserItem;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private ?UserItem $user = null;

    public function getUserInfo(): ?UserItem
    {
        if ($this->user !== null) {
            Log::info('Returning cached user info...');

            return $this->user;
        }

        $user = UserInfo::first();
        if ($user === null) {
            return null;
        }

        $user = UserItem::fromModel($user);
        if ($user->expires <= now()) {
            return null;
        }

        Log::info('Returning db user info...');

        return $this->user = $user;
    }

    public function setUser(UserItem $user): void
    {
        $this->user = $user;

        UserInfo::truncate();
        UserInfo::create($user->toArray());
    }
}
