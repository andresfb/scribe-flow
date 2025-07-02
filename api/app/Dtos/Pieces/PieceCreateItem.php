<?php

namespace App\Dtos\Pieces;

use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use Spatie\Tags\Tag;

final readonly class PieceCreateItem
{
    /**
     * @param Piece $piece
     * @param array<PieceType> $types
     * @param array<PieceStatus> $statuses
     * @param array<PiecePov> $povs
     * @param array<PieceTense> $tenses
     * @param array<Tag> $tags
     */
    public function __construct(
        public Piece $piece,
        public array $types,
        public array $statuses,
        public array $povs,
        public array $tenses,
        public array $tags,
    ) {}
}
