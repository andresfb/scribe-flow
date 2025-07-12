<?php

declare(strict_types=1);

namespace Database\Factories\Lists;

use App\Models\Lists\Tone;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PieceToneFactory extends Factory
{
    protected $model = Tone::class;

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
