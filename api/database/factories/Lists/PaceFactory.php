<?php

namespace Database\Factories\Lists;

use App\Models\Lists\Pace;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaceFactory extends Factory
{
    protected $model = Pace::class;

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
