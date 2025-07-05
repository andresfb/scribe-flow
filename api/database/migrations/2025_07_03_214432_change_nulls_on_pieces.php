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
            $table->dropForeign(['pov_id']);
            $table->unsignedBigInteger('pov_id')
                ->nullable()
                ->change();
            $table->foreign('pov_id')
                ->references('id')
                ->on('povs')
                ->onDelete('set null');

            $table->dropForeign(['tense_id']);
            $table->unsignedBigInteger('tense_id')
                ->nullable()
                ->change();
            $table->foreign('tense_id')
                ->references('id')
                ->on('tenses')
                ->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table): void {
            $table->dropForeign(['pov_id']);
            $table->unsignedBigInteger('pov_id')
                ->nullable(false)
                ->change();
            $table->foreign('pov_id')
                ->references('id')
                ->on('povs')
                ->onDelete('cascade');

            $table->dropForeign(['tense_id']);
            $table->unsignedBigInteger('tense_id')
                ->nullable(false)
                ->change();
            $table->foreign('tense_id')
                ->references('id')
                ->on('tenses')
                ->onDelete('cascade');
        });
    }
};
