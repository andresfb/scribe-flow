<?php

namespace Database\Factories\Lists;

use App\Models\Lists\PieceTone;
use Illuminate\Database\Eloquent\Factories\Factory;

class PieceToneFactory extends Factory
{
    protected $model = PieceTone::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'active' => $this->faker->boolean(),
        ];
    }
}
