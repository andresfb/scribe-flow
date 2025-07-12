<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class SanctumTokenController extends Controller
{
    public function __invoke(Request $request): array
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->first();

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken(
            name: $request->device_name,
            expiresAt: now()->addSeconds(
                Config::integer('session.lifetime')
            )
        );

        return [
            'token' => $token->plainTextToken,
        ];
    }
}
