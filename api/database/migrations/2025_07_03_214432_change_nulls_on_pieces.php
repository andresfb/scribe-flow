<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->dropForeign(['piece_pov_id']);
            $table->unsignedBigInteger('piece_pov_id')
                ->nullable()
                ->change();
            $table->foreign('piece_pov_id')
                ->references('id')
                ->on('piece_povs')
                ->onDelete('set null');

            $table->dropForeign(['piece_tense_id']);
            $table->unsignedBigInteger('piece_tense_id')
                ->nullable()
                ->change();
            $table->foreign('piece_tense_id')
                ->references('id')
                ->on('piece_tenses')
                ->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->dropForeign(['piece_pov_id']);
            $table->unsignedBigInteger('piece_pov_id')
                ->nullable(false)
                ->change();
            $table->foreign('piece_pov_id')
                ->references('id')
                ->on('piece_povs')
                ->onDelete('cascade');

            $table->dropForeign(['piece_tense_id']);
            $table->unsignedBigInteger('piece_tense_id')
                ->nullable(false)
                ->change();
            $table->foreign('piece_tense_id')
                ->references('id')
                ->on('piece_tenses')
                ->onDelete('cascade');
        });
    }
};
