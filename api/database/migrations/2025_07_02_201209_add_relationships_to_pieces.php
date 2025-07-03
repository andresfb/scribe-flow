<?php

use App\Models\Lists\PieceGenre;
use App\Models\Lists\PieceTheme;
use App\Models\Lists\PieceTone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', static function (Blueprint $table) {
            $table->foreignIdFor(PieceGenre::class)
                ->nullable()
                ->after('piece_tense_id')
                ->constrained('piece_genres');

            $table->foreignId('piece_sub_genre_id')
                ->nullable()
                ->after('piece_genre_id')
                ->constrained('piece_genres', 'id');

            $table->foreignIdFor(PieceTone::class)
                ->nullable()
                ->after('piece_sub_genre_id')
                ->constrained('piece_tones');

            $table->foreignIdFor(PieceTheme::class)
                ->nullable()
                ->after('piece_tone_id')
                ->constrained('piece_themes');

            $table->dropColumn('themes');

            $table->dropIndex('pieces_genre_index');
            $table->dropColumn('genre');

            $table->dropColumn('sub_genre');
        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table) {
            $table->dropForeign(['piece_genre_id']);
            $table->dropColumn('piece_genre_id');

            $table->dropForeign(['piece_sub_genre_id']);
            $table->dropColumn('piece_sub_genre_id');

            $table->dropForeign(['piece_tone_id']);
            $table->dropColumn('piece_tone_id');

            $table->dropForeign(['piece_theme_id']);
            $table->dropColumn('piece_theme_id');

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
