<?php

namespace Database\Factories\Lists;

use App\Models\Lists\PieceTense;
use Illuminate\Database\Eloquent\Factories\Factory;

class PieceTenseFactory extends Factory
{
    protected $model = PieceTense::class;

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
