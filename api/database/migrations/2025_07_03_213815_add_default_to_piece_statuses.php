<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('piece_statuses', static function (Blueprint $table): void {
            $table->boolean('default')
                ->after('active')
                ->default(false);
        });

        DB::table('piece_statuses')
            ->where('slug', 'seed')
            ->update(['default' => true]);
    }

    public function down(): void
    {
        Schema::table('piece_statuses', static function (Blueprint $table): void {
            $table->dropColumn('default');
        });
    }
};
