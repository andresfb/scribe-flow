<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('povs', static function (Blueprint $table) {
            $table->unsignedSmallInteger('weight')
                ->after('name')
                ->default(0);
        });

        $this->updateRecords();
    }

    public function down(): void
    {
        Schema::table('povs', static function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }

    public function updateRecords(): void
    {
        DB::table('povs')
            ->where('slug', 'first-person')
            ->update(['weight' => 9]);

        DB::table('povs')
            ->where('slug', 'third-person-limited')
            ->update(['weight' => 8]);

        DB::table('povs')
            ->where('slug', 'third-person-objective')
            ->update(['weight' => 3]);

        DB::table('povs')
            ->where('slug', 'third-person-omniscient')
            ->update(['weight' => 2]);

        DB::table('povs')
            ->where('slug', 'second-person')
            ->update(['weight' => 1]);
    }
};
