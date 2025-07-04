<?php

declare(strict_types=1);

namespace Database\Factories\Lists;

use App\Models\Lists\PieceTheme;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PieceThemeFactory extends Factory
{
    protected $model = PieceTheme::class;

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
