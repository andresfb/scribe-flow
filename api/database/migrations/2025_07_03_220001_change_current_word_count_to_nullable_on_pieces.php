<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->string('current_word_count')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->string('current_word_count')
                ->nullable(false)
                ->change();
        });
    }
};
