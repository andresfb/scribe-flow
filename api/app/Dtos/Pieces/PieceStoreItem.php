<?php

declare(strict_types=1);

namespace App\Dtos\Pieces;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class PieceStoreItem extends Data
{
    public function __construct(
        public readonly int|Optional $piece_type_id,
        public readonly int|Optional $piece_status_id,
        public readonly int|Optional $pov_id,
        public readonly int|Optional $tense_id,
        public readonly int|Optional $genre_id,
        public readonly int|Optional $sub_genre_id,
        public readonly int|Optional $tone_id,
        public readonly int|Optional $theme_id,
        public readonly int|Optional $character_id,
        public readonly int|Optional $pace_id,
        public readonly int|Optional $setting_id,
        public readonly string|Optional $title,
        public readonly string|Optional $setting_time_period,
        public readonly string|Optional $synopsis,
        public readonly int|Optional $target_word_count,
        public readonly int|Optional $current_word_count,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public readonly Carbon|Optional $start_date,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public readonly Carbon|Optional $target_completion_date,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public readonly Carbon|Optional $completion_date,
        public readonly array|Optional $themes,
        public readonly array|Optional $tags,
    ) {}
}
