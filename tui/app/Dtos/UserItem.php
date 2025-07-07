<?php

namespace App\Dtos;

use App\Models\UserInfo;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Config;

final class UserItem
{
    public function __construct(
        public string $name,
        public string $email,
        public string $token,
        public CarbonImmutable $expires,
    ) {}

    public static function from(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['token'],
            CarbonImmutable::parse(
                $data['expires'],
                Config::string('constants.timezone')
            ),
        );
    }

    public static function fromModel(UserInfo $info): self
    {
        return new self(
            $info->name,
            $info->email,
            $info->token,
            CarbonImmutable::parse($info->expires),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'expires' => $this->expires
                ->timezone(Config::string('constants.timezone'))
                ->toDateTimeString(),
        ];
    }
}
