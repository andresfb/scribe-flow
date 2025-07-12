<?php

declare(strict_types=1);

namespace Database\Factories\Pieces;

use App\Models\Lists\Genre;
use App\Models\Lists\Pace;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceType;
use App\Models\Lists\Pov;
use App\Models\Lists\Setting;
use App\Models\Lists\Storyline;
use App\Models\Lists\Style;
use App\Models\Lists\Tense;
use App\Models\Lists\Theme;
use App\Models\Lists\Timeline;
use App\Models\Lists\Tone;
use App\Models\Pieces\Piece;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PieceFactory extends Factory
{
    protected $model = Piece::class;

    public function definition(): array
    {
        $now = Carbon::now()
            ->subDays(
                $this->faker->numberBetween(0, 25)
            );

        return [
            'title' => $this->faker->word(),
            'idea' => $this->faker->paragraphs(asText: true),
            'target_word_count' => $this->faker->randomNumber(),
            'current_word_count' => $this->faker->randomNumber(),
            'start_date' => $now->clone()->addWeeks($this->faker->numberBetween(1, 3)),
            'target_completion_date' => $now->clone()->addDays($this->faker->numberBetween(25, 90)),
            'completion_date' => $now->clone()->addDays($this->faker->numberBetween(30, 365)),
            'created_at' => $now,
            'updated_at' => $now,

            'user_id' => User::factory(),
            'piece_type_id' => PieceType::factory(),
            'piece_status_id' => PieceStatus::factory(),
            'pov_id' => Pov::factory(),
            'tense_id' => Tense::factory(),
            'genre_id' => Genre::factory(),
            'sub_genre_id' => Genre::factory(),
            'tone_id' => Tone::factory(),
            'theme_id' => Theme::factory(),
            'character_id' => '', // TODO: add the character factory
            'piece_id' => Pace::factory(),
            'setting_id' => Setting::factory(),
            'timeline_id' => Timeline::factory(),
            'storyline_id' => Storyline::factory(),
            'style_id' => Style::factory(),
        ];
    }
}
