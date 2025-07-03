<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('piece_types', static function (Blueprint $table) {
            $table->text('description')
                ->after('name')
                ->nullable();

            $table->unsignedSmallInteger('min_count')
                ->after('description')
                ->default(0);

            $table->unsignedSmallInteger('max_count')
                ->after('min_count')
                ->default(0);

            $table->boolean('randomizable')
                ->after('max_count')
                ->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('piece_types', static function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('min_count');
            $table->dropColumn('max_count');
        });
    }
};
