<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tags', static function (Blueprint $table) {
            $table->timestamp('deleted_at')
                ->after('order_column')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tags', static function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
