<?php

namespace App\Dtos\Pieces;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PieceStoreItem extends Data
{
    public function __construct(
        public readonly int|Optional $piece_type_id,
        public readonly int|Optional $piece_status_id,
        public readonly int|Optional $piece_pov_id,
        public readonly int|Optional $piece_tense_id,
        public readonly int|Optional $piece_genre_id,
        public readonly int|Optional $piece_sub_genre_id,
        public readonly int|Optional $piece_tone_id,
        public readonly int|Optional $piece_theme_id,
        public readonly string|Optional $title,
        public readonly string|Optional $setting_time_period,
        public readonly string|Optional $setting_location,
        public readonly string|Optional $synopsis,
        public readonly int|Optional $target_word_count,
        public readonly int|Optional $current_word_count,
        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d")]
        public readonly Carbon|Optional $start_date,
        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d")]
        public readonly Carbon|Optional $target_completion_date,
        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d")]
        public readonly Carbon|Optional $completion_date,
        public readonly array|Optional $themes,
        public readonly array|Optional $tags,
    ) {}
}
