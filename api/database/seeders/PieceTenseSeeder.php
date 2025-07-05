<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PieceTenseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tenses')->insert([
            ['slug' => 'past', 'name' => 'Past', 'active' => true, 'order' => 1],
            ['slug' => 'present', 'name' => 'Present', 'active' => true, 'order' => 2],
            ['slug' => 'future', 'name' => 'Future', 'active' => true, 'order' => 3],
            ['slug' => 'mixed', 'name' => 'Mixed', 'active' => true, 'order' => 4],
        ]);
    }
}
