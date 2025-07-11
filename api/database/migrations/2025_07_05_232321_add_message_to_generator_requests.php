<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table) {
            $table->text('message')
                ->after('prompt')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }
};
