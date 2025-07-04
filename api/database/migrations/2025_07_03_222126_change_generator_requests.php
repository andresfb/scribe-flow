<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table) {
            $table->string('service')
                ->nullable()
                ->change();

            $table->string('model')
                ->nullable()
                ->change();

            $table->dropColumn('content');
        });
    }

    public function down(): void
    {
        Schema::table('generator_requests', static function (Blueprint $table) {
            $table->string('service')->nullable(false)->change();

            $table->string('model')->nullable(false)->change();

            $table->json('content')
                ->after('request')
                ->nullable();
        });
    }
};
