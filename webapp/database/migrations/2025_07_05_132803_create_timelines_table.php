<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timelines', static function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->unsignedSmallInteger('weight')->default(0);
            $table->boolean('active')->default(true);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });

        $this->seedTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $pace => $weight) {
            DB::table('timelines')->insert([
                'slug' => str($pace)->slug(),
                'name' => $pace,
                'weight' => $weight,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            '14th Century' => 1,
            '15th Century' => 1,
            '16th Century' => 1,
            '17th Century' => 1,
            '18th Century' => 1,
            '19th Century' => 1,
            '1st Century' => 1,
            '1st Century Bce' => 1,
            '20th Century' => 1,
            '21st Century' => 1,
            '22nd Century' => 1,
            '23Rd Century' => 1,
            '2nd Century' => 1,
            '2nd Century Bce' => 1,
            '3rd Century' => 1,
            '3rd Century Bce' => 1,
            '4th Century' => 1,
            '4th Century Bce' => 1,
            '5th Century Bce' => 1,
            '5th Century' => 1,
            'Alternative Timeline' => 4,
            'Ancient History' => 2,
            'Bronze Age' => 1,
            'Distant Future' => 6,
            'Early Classical' => 2,
            'Early Medieval' => 2,
            'Early Modern' => 3,
            'Early Renaissance' => 2,
            'Epic Future' => 5,
            'Era of Legends' => 4,
            'Far Future' => 5,
            'Iron Age' => 1,
            'Late Classical' => 3,
            'Late Medieval' => 3,
            'Late Renaissance' => 3,
            'Middle Renaissance' => 3,
            'Mythic Period' => 4,
            'Near Future' => 6,
            'Stone Age' => 1,
            'Contemporary' => 9,
            'Recent Past' => 6,
            'Future' => 6,
            'Prehistoric Era' => 1,
            'Dark Ages' => 3,
            'Age of Exploration' => 3,
            'Victorian Era' => 4,
            'Roaring Twenties' => 5,
            'Cold War Era' => 5,
            'Post-Apocalyptic Future' => 7,
            'Cyberpunk Future' => 8,
            'Alternate History' => 5,
            'Age of Enlightenment' => 4,
            'Gilded Age' => 3,
            'Interwar Period' => 3,
            'Space Age' => 6,
            'Digital Age' => 8,
        ];
    }
};
