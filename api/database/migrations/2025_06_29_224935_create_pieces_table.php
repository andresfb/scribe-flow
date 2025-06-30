<?php

use App\Models\PieceStatus;
use App\Models\PieceType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pieces', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained('users');
            $table->foreignIdFor(PieceType::class)
                ->constrained('piece_types');
            $table->foreignIdFor(PieceStatus::class)
                ->constrained('piece_statuses');
            $table->string('slug')->index();
            $table->string('title', 150);
            $table->text('synopsis')->nullable();
            $table->integer('target_word_count')->nullable();
            $table->integer('current_word_count');
            $table->date('start_date')->nullable();
            $table->date('target_completion_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'slug'], 'idx_user_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
