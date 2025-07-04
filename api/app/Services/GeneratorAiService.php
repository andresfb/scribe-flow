<?php

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Prism;
use Prism\Prism\Text\Response;

class GeneratorAiService
{
    public function generate(PromptItem $promptItem): Response
    {
        Log::notice('Asking the AI for content');

        return Prism::text()
            ->using(
                $promptItem->generator->provider,
                $promptItem->generator->getModel(),
            )
            ->withMaxTokens($promptItem->generator->max_tokens)
            ->usingTemperature($promptItem->generator->temperature)
            ->withProviderOptions([
                'presence_penalty' => $promptItem->generator->presence_penalty,
            ])
            ->withClientOptions([
                'timeout' => $promptItem->generator->request_timeout
            ])
            ->withPrompt($promptItem->prompt)
            ->asText();
    }
}
