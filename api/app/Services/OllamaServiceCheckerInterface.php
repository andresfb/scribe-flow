<?php

namespace App\Services;

use App\Interfaces\ServiceCheckerInterface;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class OllamaServiceCheckerInterface implements ServiceCheckerInterface
{
    public function isAvailable(): bool
    {
        try {
            return $this->sendRequest()->successful();
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    private function sendRequest(): Response
    {
        $url = sprintf(
            '%s%s',
            Config::string('generators.checkers.ollama.url'),
            '/api/tags'
        );

        $http = Http::timeout(
            Config::integer('generators.checkers.ollama.status_timeout')
        )
            ->throw()
            ->withOptions([
                'verify' => false,
            ]);

        return $http->get($url);
    }
}
