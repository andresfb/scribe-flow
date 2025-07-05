<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', static function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->boolean('active')->default(true);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });

        $this->seedTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $character) {
            DB::table('settings')->insert([
                'slug' => str($character)->slug(),
                'name' => $character,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            'Europe',
            'America',
            'Asia',
            'Africa',
            'Pacific',
            'Mediterranean',
            'Australia',
            'North Atlantic',
            'Scandinavia',
            'Middle East',
            'North Africa',
            'Sub-Saharan Africa',
            'In Another Galaxy',
            'In Another Solar System',
            'On Another Planet',
            'Underwater',
            'In Space',
            'In Orbit',
            'Italy',
            'France',
            'Germany',
            'England',
            'India',
            'Japan',
            'China',
            'Korea',
            'New Zealand',
            'Egypt',
            'Brazil',
            'The Moon',
            'Mars',
            'Small Town Rural',
            'Big City Life',
            'Across The Whole Planet',
            'Miami',
            'New York',
            'Los Angeles',
            'Any Town',
            'At Work',
            'At Church',
            'Europe',
            'North America',
            'South America',
            'Near Future City',
            'Far Future City',
            'Of Your Choosing',
        ];
    }
};
