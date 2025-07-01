<?php

namespace Database\Factories\Lists;

use App\Models\Lists\PieceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PieceTypeFactory extends Factory
{
    protected $model = PieceType::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->randomNumber(),
        ];
    }
}
