<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PieceStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('piece_statuses')->insert([
            ['slug' => 'seed', 'name' => 'Seed', 'active' => true, 'order' => 1],
            ['slug' => 'idea', 'name' => 'Idea', 'active' => true, 'order' => 2],
            ['slug' => 'planning', 'name' => 'Planning', 'active' => true, 'order' => 3],
            ['slug' => 'research', 'name' => 'Research', 'active' => true, 'order' => 4],
            ['slug' => 'drafting', 'name' => 'Drafting', 'active' => true, 'order' => 5],
            ['slug' => 'editing', 'name' => 'Editing', 'active' => true, 'order' => 6],
            ['slug' => 'revision', 'name' => 'Revision', 'active' => true, 'order' => 7],
            ['slug' => 'beta-reading', 'name' => 'Beta Reading', 'active' => true, 'order' => 8],
            ['slug' => 'submission', 'name' => 'Submission', 'active' => true, 'order' => 9],
            ['slug' => 'published', 'name' => 'Published', 'active' => true, 'order' => 10],
            ['slug' => 'abandoned', 'name' => 'Abandoned', 'active' => true, 'order' => 11],
        ]);
    }
}
