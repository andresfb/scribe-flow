<?php

namespace App\Dtos\Ai;

use Spatie\LaravelData\Data;

final class GeneratorItem extends Data
{
    public function __construct(
        public readonly string $provider,
        public readonly bool $enabled,
        public readonly array $models,
        public readonly int $maxTokens,
        public readonly float $presencePenalty,
        public readonly int $requestTimeout,
        public readonly float $temperature,
    ) {}

    public function getModel(): string
    {
        return (string) collect($this->models)->random();
    }
}
