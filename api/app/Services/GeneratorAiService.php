<?php

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use Prism\Prism\Prism;
use Prism\Prism\Text\Response;

class GeneratorAiService
{
    public function generate(PromptItem $promptItem): Response
    {
        return Prism::text()
            ->using(
                $promptItem->generator->provider,
                $promptItem->generator->getModel(),
            )
            ->withMaxTokens($promptItem->generator->maxTokens)
            ->usingTemperature($promptItem->generator->temperature)
            ->withProviderOptions([
                'presence_penalty' => $promptItem->generator->presencePenalty,
            ])
            ->withClientOptions([
                'timeout' => $promptItem->generator->requestTimeout
            ])
            ->withPrompt($promptItem->prompt)
            ->asText();
    }
}
