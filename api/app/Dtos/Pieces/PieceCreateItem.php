<?php

declare(strict_types=1);

namespace App\Dtos\Pieces;

use App\Models\Lists\PieceGenre;
use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceTheme;
use App\Models\Lists\PieceTone;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use Spatie\Tags\Tag;

final readonly class PieceCreateItem
{
    /**
     * @param  array<PieceType>  $types
     * @param  array<PieceStatus>  $statuses
     * @param  array<PiecePov>  $povs
     * @param  array<PieceTense>  $tenses
     * @param  array<PieceGenre>  $genres
     * @param  array<PieceTone>  $tones
     * @param  array<PieceTheme>  $themes
     * @param  array<Tag>  $tags
     */
    public function __construct(
        public Piece $piece,
        public array $types,
        public array $statuses,
        public array $povs,
        public array $tenses,
        public array $genres,
        public array $tones,
        public array $themes,
        public array $tags,
    ) {}
}
