<?php

declare(strict_types=1);

namespace Database\Factories\Lists;

use App\Models\Lists\PiecePov;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PiecePovFactory extends Factory
{
    protected $model = PiecePov::class;

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
