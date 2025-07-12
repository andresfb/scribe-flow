<?php

namespace Database\Factories;

use App\Models\Lists\Timeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimelineFactory extends Factory
{
    protected $model = Timeline::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'weight' => $this->faker->randomNumber(),
            'active' => $this->faker->boolean(),
        ];
    }
}
