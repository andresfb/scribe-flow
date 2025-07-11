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
        Schema::create('tenses', static function (Blueprint $table): void {
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
        Schema::dropIfExists('tenses');
    }

    private function seedTable(): void
    {
        DB::table('tenses')->insert([
            ['slug' => 'past', 'name' => 'Past', 'active' => true, 'order' => 1],
            ['slug' => 'present', 'name' => 'Present', 'active' => true, 'order' => 2],
            ['slug' => 'future', 'name' => 'Future', 'active' => true, 'order' => 3],
            ['slug' => 'mixed', 'name' => 'Mixed', 'active' => true, 'order' => 4],
        ]);
    }
};
