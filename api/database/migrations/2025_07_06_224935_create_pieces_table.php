<?php

declare(strict_types=1);

use App\Models\Lists\Character;
use App\Models\Lists\Genre;
use App\Models\Lists\Pace;
use App\Models\Lists\Pov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\Setting;
use App\Models\Lists\Storyline;
use App\Models\Lists\Style;
use App\Models\Lists\Tense;
use App\Models\Lists\PieceType;
use App\Models\Lists\Theme;
use App\Models\Lists\Timeline;
use App\Models\Lists\Tone;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pieces', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignIdFor(PieceType::class)
                ->constrained('piece_types');
            $table->foreignIdFor(PieceStatus::class)
                ->constrained('piece_statuses');
            $table->foreignIdFor(Pov::class)
                ->nullable()
                ->constrained('povs');
            $table->foreignIdFor(Tense::class)
                ->nullable()
                ->constrained('tenses');
            $table->foreignIdFor(Genre::class)
                ->nullable()
                ->constrained('genres');
            $table->foreignId('sub_genre_id')
                ->nullable()
                ->constrained('genres', 'id');
            $table->foreignIdFor(Tone::class)
                ->nullable()
                ->constrained('tones');
            $table->foreignIdFor(Theme::class)
                ->nullable()
                ->constrained('themes');
            $table->foreignIdFor(Character::class)
                ->nullable()
                ->constrained('characters');
            $table->foreignIdFor(Pace::class)
                ->nullable()
                ->constrained('paces');
            $table->foreignIdFor(Setting::class)
                ->nullable()
                ->constrained('settings');
            $table->foreignIdFor(Timeline::class)
                ->nullable()
                ->constrained('timelines');
            $table->foreignIdFor(Storyline::class)
                ->nullable()
                ->constrained('storylines');
            $table->foreignIdFor(Style::class)
                ->nullable()
                ->constrained('styles');
            $table->string('slug')->index();
            $table->string('title', 150);
            $table->text('idea')->nullable();
            $table->integer('target_word_count')->nullable();
            $table->integer('current_word_count')->nullable();
            $table->date('start_date')->nullable();
            $table->date('target_completion_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
