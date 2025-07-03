<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PieceTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('piece_types')->insert([
            [
                'slug' => 'novel',
                'name' => 'Novel',
                'description' => 'A full-length, standalone narrative with multiple characters, interwoven subplots and often a fully realized setting or world.',
                'min_count' => 50000,
                'max_count' => 120000,
                'randomizable' => true,
                'active' => true,
                'order' => 1
            ],
            [
                'slug' => 'novella',
                'name' => 'Novella',
                'description' => 'A “middle-length” work that allows for deeper character development and thematic exploration than a short story, but remains more focused and concise than a novel.',
                'min_count' => 15000,
                'max_count' => 40000,
                'randomizable' => true,
                'active' => true,
                'order' => 2
            ],
            [
                'slug' => 'short-story',
                'name' => 'Short Story',
                'description' => 'A brief narrative centered on a single event, character or moment; emphasis is on economy of language, a tight plot, and often a twist or thematic punch.',
                'min_count' => 1000,
                'max_count' => 10000,
                'randomizable' => true,
                'active' => true,
                'order' => 3
            ],
            [
                'slug' => 'screenplay',
                'name' => 'Screenplay',
                'description' => 'A blueprint for a film or TV production, written in industry-standard format (scene headings, action lines, dialogue). Pacing is tightly linked to page count.',
                'min_count' => 18000,
                'max_count' => 25000,
                'randomizable' => false,
                'active' => true,
                'order' => 4
            ],
            [
                'slug' => 'poem',
                'name' => 'Poem',
                'description' => 'A verse work that uses meter, rhythm, imagery and/or line breaks to convey emotion or ideas. Poetic forms range from very short (e.g. haiku) to book-length epics.',
                'min_count' => 50,
                'max_count' => 200,
                'randomizable' => false,
                'active' => true,
                'order' => 5
            ],
            [
                'slug' => 'other',
                'name' => 'Other',
                'description' => 'A flexible category for any fiction or narrative form outside the standard novel/novella/short-story/screenplay/poem definitions—think flash-chapbooks, graphic or illustrated tales, interactive (“choose-your-own-adventure”) pieces, multimedia narratives, audio dramas, or genre-blending experiments.',
                'min_count' => 500,
                'max_count' => 500000,
                'randomizable' => false,
                'active' => true,
                'order' => 6
            ],
        ]);
    }
}
