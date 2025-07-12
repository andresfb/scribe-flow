<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenses', static function (Blueprint $table) {
            $table->unsignedSmallInteger('weight')
                ->after('name')
                ->default(0);
        });

        $this->updateRecords();
    }

    public function down(): void
    {
        Schema::table('tenses', static function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }

    public function updateRecords(): void
    {
        DB::table('tenses')
            ->where('slug', 'past')
            ->update(['weight' => 7]);

        DB::table('tenses')
            ->where('slug', 'present')
            ->update(['weight' => 9]);

        DB::table('tenses')
            ->where('slug', 'future')
            ->update(['weight' => 1]);
    }
};
