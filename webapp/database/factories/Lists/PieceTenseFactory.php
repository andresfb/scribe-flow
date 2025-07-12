<?php

declare(strict_types=1);

namespace Database\Factories\Lists;

use App\Models\Lists\Tense;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PieceTenseFactory extends Factory
{
    protected $model = Tense::class;

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
