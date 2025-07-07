<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $email
 * @property string $token
 * @property CarbonImmutable $expires
 */
class UserInfo extends Model
{
    protected $fillable = [
        'name',
        'email',
        'token',
        'expires',
    ];

    protected function casts(): array
    {
        return [
            'expires' => 'datetime',
        ];
    }
}
