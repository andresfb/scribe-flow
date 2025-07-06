<?php

declare(strict_types=1);

namespace App\Dtos\Ai;

use Spatie\LaravelData\Data;

final class GeneratorItem extends Data
{
    private string $model = '';

    public function __construct(
        public readonly string $name,
        public readonly string $provider,
        public readonly bool $enabled,
        public readonly array $models,
        public readonly int $max_tokens,
        public readonly float $presence_penalty,
        public readonly int $request_timeout,
        public readonly float $temperature,
        public readonly bool $check_service,
        public readonly ?string $service_checker,
    ) {}

    public function getModel(): string
    {
        if (! blank($this->model)) {
            return $this->model;
        }

        $this->model = (string) collect($this->models)->random();

        return $this->model;
    }

    public function getCacheKey(): string
    {
        return md5(sprintf(
            "AI:PROVIDER:%s:MODEL:%s",
            mb_strtoupper($this->name),
            mb_strtoupper($this->getModel()),
        ));
    }
}
