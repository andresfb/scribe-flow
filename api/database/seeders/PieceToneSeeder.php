<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PieceToneSeeder extends Seeder
{
    public function run(): void
    {
        $genres = DB::connection('boogie')
            ->table('tones')
            ->get();

        foreach ($genres as $genre) {
            DB::table('piece_tones')->insert([
                'slug' => str($genre->title)->slug(),
                'name' => $genre->title,
                'description' => $genre->description,
                'active' => (bool) $genre->active,
            ]);
        }
    }
}
