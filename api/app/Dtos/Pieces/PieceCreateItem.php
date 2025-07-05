<?php

declare(strict_types=1);

namespace App\Dtos\Pieces;

use App\Models\Lists\Genre;
use App\Models\Lists\Pov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\Tense;
use App\Models\Lists\Theme;
use App\Models\Lists\Tone;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use Spatie\Tags\Tag;

final readonly class PieceCreateItem
{
    /**
     * @param  array<PieceType>  $types
     * @param  array<PieceStatus>  $statuses
     * @param  array<Pov>  $povs
     * @param  array<Tense>  $tenses
     * @param  array<Genre>  $genres
     * @param  array<Tone>  $tones
     * @param  array<Theme>  $themes
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
        public array $characters,
        public array $paces,
        public array $settings,
        public array $tags,
    ) {}
}
