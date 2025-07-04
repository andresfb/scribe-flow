<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PieceTypeSeeder::class,
            PieceStatusSeeder::class,
            PiecePovSeeder::class,
            PieceTenseSeeder::class,
            PieceGenreSeeder::class,
            PieceToneSeeder::class,
            PieceThemeSeeder::class,
        ]);
    }
}
