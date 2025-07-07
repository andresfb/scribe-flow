<?php

namespace App\Services;

use App\Traits\Screenable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Throwable;

class LoginService
{
    use Screenable;

    /**
     * @throws Throwable
     */
    public function login(string $email, string $password): array
    {
        $this->info("Requesting the API to login...\n");

        $result = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->throw()
            ->timeout(60)
            ->baseUrl(Config::string('constants.api.url'))
            ->post(
                Config::string('constants.api.login'),
                [
                    'email' => $email,
                    'password' => $password,
                    'device_name' => Config::string('app.name'),
                ]
            );

        return $result->json();
    }
}
