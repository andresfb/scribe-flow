<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piece_tenses', static function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piece_tenses');
    }
};
