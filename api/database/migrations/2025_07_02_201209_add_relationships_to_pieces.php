<?php

declare(strict_types=1);

use App\Models\Lists\Genre;
use App\Models\Lists\Theme;
use App\Models\Lists\Tone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->foreignIdFor(Genre::class)
                ->nullable()
                ->after('tense_id')
                ->constrained('genres');

            $table->foreignId('sub_genre_id')
                ->nullable()
                ->after('genre_id')
                ->constrained('genres', 'id');

            $table->foreignIdFor(Tone::class)
                ->nullable()
                ->after('sub_genre_id')
                ->constrained('tones');

            $table->foreignIdFor(Theme::class)
                ->nullable()
                ->after('tone_id')
                ->constrained('themes');

            $table->dropColumn('themes');

            $table->dropIndex('genre_index');
            $table->dropColumn('genre');

            $table->dropColumn('sub_genre');
        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');

            $table->dropForeign(['sub_genre_id']);
            $table->dropColumn('sub_genre_id');

            $table->dropForeign(['tone_id']);
            $table->dropColumn('tone_id');

            $table->dropForeign(['theme_id']);
            $table->dropColumn('theme_id');

            $table->json('themes')
                ->after('current_word_count')
                ->nullable();

            $table->string('genre', 100)
                ->after('title')
                ->index()
                ->nullable();

            $table->string('sub_genre', 100)
                ->after('genre')
                ->nullable();
        });
    }
};
