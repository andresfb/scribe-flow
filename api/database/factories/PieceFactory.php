<?php

namespace Database\Factories;

use App\Models\Piece;
use App\Models\PieceStatus;
use App\Models\PieceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PieceFactory extends Factory
{
    protected $model = Piece::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->word(),
            'synopsis' => $this->faker->word(),
            'target_word_count' => $this->faker->randomNumber(),
            'current_word_count' => $this->faker->randomNumber(),
            'start_date' => Carbon::now(),
            'target_completion_date' => Carbon::now(),
            'completion_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'piece_type_id' => PieceType::factory(),
            'piece_status_id' => PieceStatus::factory(),
        ];
    }
}
