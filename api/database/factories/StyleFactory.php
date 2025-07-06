<?php

namespace Database\Factories;

use App\Models\Lists\Style;
use Illuminate\Database\Eloquent\Factories\Factory;

class StyleFactory extends Factory
{
    protected $model = Style::class;

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
