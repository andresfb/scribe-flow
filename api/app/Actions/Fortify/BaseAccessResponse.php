<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

abstract class BaseAccessResponse
{
    use ApiResponses;

    protected function accessResponse(Request $request, string $message): JsonResponse
    {
        $user = User::where('email', $request->email)
            ->first();

        $expires = now()->addSeconds(
            Config::integer('session.lifetime')
        );

        return $this->ok(
            message: $message,
            data: [
                'expires_at' => $expires->toDateTimeString(),
                'token' => $user->createToken(
                    name: 'auth_token',
                    expiresAt: $expires,
                )->plainTextToken,
            ],
        );
    }
}
