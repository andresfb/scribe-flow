<?php

declare(strict_types=1);

namespace App\Dtos\Users;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

final class UserItem extends Data
{
    public function __construct(
        public readonly string $name = '',
        public readonly string $email = '',
        public readonly string $password = '',
        public readonly string $timezone = '',
        public readonly bool $isDefault = false,
    ) {}

    public function toArray(): array
    {
        $userData = parent::toArray();

        if (blank($this->password)) {
            unset($userData['password']);
        } else {
            $userData['password'] = Hash::make($this->password);
            $userData['email_verified_at'] = now();
        }

        if (blank($this->timezone)) {
            unset($userData['timezone']);
        }

        if (! $this->isDefault) {
            unset($userData['is_default']);
        }

        return $userData;
    }

    public function isDirty(): bool
    {
        $userData = parent::toArray();

        $found = false;
        foreach ($userData as $value) {
            if (! blank($value)) {
                continue;
            }

            $found = true;
            break;
        }

        return $found;
    }
}
