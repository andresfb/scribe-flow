<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table): void {
            $table->text('prompt')
                ->nullable()
                ->after('model');
        });
    }

    public function down(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table): void {
            $table->dropColumn('prompt');
        });
    }
};
