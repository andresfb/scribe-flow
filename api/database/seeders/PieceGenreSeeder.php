<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PieceGenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = DB::connection('boogie')
            ->table('genres')
            ->get();

        foreach ($genres as $genre) {
            DB::table('piece_genres')->insert([
                'slug' => str($genre->title)->slug(),
                'name' => $genre->title,
                'description' => str($genre->description)
                    ->replace('novels', 'stories')
                    ->replace('Novels', 'Stories')
                    ->value(),
                'active' => (bool) $genre->active,
            ]);
        }
    }
}
