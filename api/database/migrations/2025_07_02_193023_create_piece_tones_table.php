<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piece_tones', static function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->text('description');
            $table->boolean('active')->default(true);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piece_tones');
    }
};
