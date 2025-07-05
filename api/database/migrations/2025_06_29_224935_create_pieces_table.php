<?php

declare(strict_types=1);

use App\Models\Lists\Pov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\Tense;
use App\Models\Lists\PieceType;
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
                ->constrained('povs');
            $table->foreignIdFor(Tense::class)
                ->constrained('tenses');
            $table->string('slug')->index();
            $table->string('title', 150);
            $table->string('genre', 100)->index()->nullable();
            $table->string('sub_genre', 100)->nullable();
            $table->string('setting_time_period')->nullable();
            $table->string('setting_location')->nullable();
            $table->text('synopsis')->nullable();
            $table->integer('target_word_count')->nullable();
            $table->integer('current_word_count');
            $table->json('themes')->nullable();
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
