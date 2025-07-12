<?php

namespace Database\Factories\Lists;

use App\Models\Lists\Storyline;
use Illuminate\Database\Eloquent\Factories\Factory;

class StorylineFactory extends Factory
{
    protected $model = Storyline::class;

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
