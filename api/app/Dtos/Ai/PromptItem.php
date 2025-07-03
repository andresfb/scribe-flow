<?php

namespace App\Dtos\Ai;

use App\Dtos\Pieces\PieceStoreItem;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class PromptItem extends Data
{
    public function __construct(
        public readonly GeneratorItem|Optional $generator,
        public readonly PieceStoreItem|Optional $pieceItem,
        public readonly string|Optional $prompt,
    ) {}

    public function withGenerator(Collection $item): self
    {

    }
}
