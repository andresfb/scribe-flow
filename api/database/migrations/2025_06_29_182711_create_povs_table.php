<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('povs', static function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });

        $this->seedTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('povs');
    }

    private function seedTable(): void
    {
        DB::table('povs')->insert([
            ['slug' => 'first-person', 'name' => 'First Person', 'active' => true, 'order' => 1],
            ['slug' => 'second-person', 'name' => 'Second Person', 'active' => true, 'order' => 2],
            ['slug' => 'third-person-limited', 'name' => 'Third Person Limited', 'active' => true, 'order' => 3],
            ['slug' => 'third-person-objective', 'name' => 'Third Person Objective', 'active' => true, 'order' => 4],
            ['slug' => 'third-person-omniscient', 'name' => 'Third Person Omniscient', 'active' => true, 'order' => 5],
            ['slug' => 'multiple', 'name' => 'Multiple', 'active' => true, 'order' => 6],
            ['slug' => 'other', 'name' => 'Other', 'active' => true, 'order' => 7],
        ]);
    }
};
