<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Dtos\Users\UserItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateUserAction
{
    /**
     * @throws Throwable
     */
    public function handle(int $userId, UserItem $userItem): User
    {
        return DB::transaction(static function () use ($userId, $userItem): User {
            $user = User::where('id', $userId)
                ->firstOrFail();

            $user->update($userItem->toArray());

            return $user->fresh();
        });
    }
}
