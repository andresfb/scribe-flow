<?php

namespace Database\Factories;

use App\Models\Lists\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'active' => $this->faker->boolean(),
        ];
    }
}
