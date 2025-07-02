<?php

namespace Database\Factories\Pieces;

use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PieceFactory extends Factory
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
            'genre' => $this->faker->word(),
            'sub_genre' => $this->faker->word(),
            'setting_time_period' => $this->faker->paragraph(),
            'setting_location' => $this->faker->word(),
            'synopsis' => $this->faker->paragraphs(asText: true),
            'target_word_count' => $this->faker->randomNumber(),
            'current_word_count' => $this->faker->randomNumber(),
            'start_date' => $now->clone()->addWeeks($this->faker->numberBetween(1, 3)),
            'target_completion_date' => $now->clone()->addDays($this->faker->numberBetween(25, 90)),
            'completion_date' => $now->clone()->addDays($this->faker->numberBetween(30, 365)),
            'created_at' => $now,
            'updated_at' => $now,
            'themes' => [
                $this->faker->slug() => $this->faker->words($this->faker->numberBetween(1, 2), true),
                $this->faker->slug() => [
                    $this->faker->words($this->faker->numberBetween(1, 3), true),
                    $this->faker->words($this->faker->numberBetween(1, 3), true),
                    $this->faker->words($this->faker->numberBetween(1, 3), true),
                ],
                $this->faker->slug() => [
                    $this->faker->word(),
                    $this->faker->word(),
                    $this->faker->word(),
                ]
            ],

            'user_id' =>User::factory(),
            'piece_type_id' => PieceType::factory(),
            'piece_status_id' => PieceStatus::factory(),
            'piece_pov_id' => PiecePov::factory(),
            'piece_tense_id' => PieceTense::factory(),
        ];
    }
}
