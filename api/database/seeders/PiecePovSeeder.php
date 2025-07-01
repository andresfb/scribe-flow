<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PiecePovSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('piece_types')->insert([
            ['slug' => 'novel', 'name' => 'Novel', 'active' => true, 'order' => 1],
            ['slug' => 'novella', 'name' => 'Novella', 'active' => true, 'order' => 2],
            ['slug' => 'short-story', 'name' => 'Short Story', 'active' => true, 'order' => 3],
            ['slug' => 'screenplay', 'name' => 'Screenplay', 'active' => true, 'order' => 4],
            ['slug' => 'poem', 'name' => 'Poem', 'active' => true, 'order' => 5],
            ['slug' => 'other', 'name' => 'Other', 'active' => true, 'order' => 6],
        ]);
    }
}
