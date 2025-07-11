<?php

declare(strict_types=1);

namespace App\Dtos\Ai;

use App\Dtos\Pieces\PieceItem;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class PromptItem extends Data
{
    public function __construct(
        public readonly GeneratorItem|Optional $generator,
        public readonly PieceItem|Optional     $pieceItem,
        public readonly string|Optional        $prompt,
    ) {}

    public function withGenerator(GeneratorItem $item): self
    {
        return new self(
            $item,
            $this->pieceItem,
            $this->prompt
        );
    }
}
