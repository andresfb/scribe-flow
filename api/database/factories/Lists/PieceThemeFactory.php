<?php

declare(strict_types=1);

namespace Database\Factories\Lists;

use App\Models\Lists\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PieceThemeFactory extends Factory
{
    protected $model = Theme::class;

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
