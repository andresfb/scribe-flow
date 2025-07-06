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
        Schema::create('piece_statuses', static function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->boolean('default')->default(false);
            $table->unsignedSmallInteger('order')->default(0);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });

        $this->seedTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('piece_statuses');
    }

    private function seedTable(): void
    {
        DB::table('piece_statuses')->insert([
            ['slug' => 'seed', 'name' => 'Seed', 'active' => true, 'default' => true, 'order' => 1],
            ['slug' => 'idea', 'name' => 'Idea', 'active' => true, 'default' => false, 'order' => 2],
            ['slug' => 'planning', 'name' => 'Planning', 'active' => true, 'default' => false, 'order' => 3],
            ['slug' => 'research', 'name' => 'Research', 'active' => true, 'default' => false, 'order' => 4],
            ['slug' => 'drafting', 'name' => 'Drafting', 'active' => true, 'default' => false, 'order' => 5],
            ['slug' => 'editing', 'name' => 'Editing', 'active' => true, 'default' => false, 'order' => 6],
            ['slug' => 'revision', 'name' => 'Revision', 'active' => true, 'default' => false, 'order' => 7],
            ['slug' => 'beta-reading', 'name' => 'Beta Reading', 'active' => true, 'default' => false, 'order' => 8],
            ['slug' => 'submission', 'name' => 'Submission', 'active' => true, 'default' => false, 'order' => 9],
            ['slug' => 'published', 'name' => 'Published', 'active' => true, 'default' => false, 'order' => 10],
            ['slug' => 'abandoned', 'name' => 'Abandoned', 'active' => true, 'default' => false, 'order' => 11],
        ]);
    }
};
