<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paces', static function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->text('description');
            $table->boolean('active')->default(true);

            $table->index(['active', 'slug'], 'idx_active_slug');
        });

        $this->seedTable();
    }

    public function down(): void
    {
        Schema::dropIfExists('paces');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $pace => $description) {
            DB::table('paces')->insert([
                'slug' => str($pace)->slug(),
                'name' => $pace,
                'description' => $description,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            "Fast-paced" => "Events in these exciting books unfold rapidly, moving the reader quickly through the story.",
            "Intensifying" => "These books gradually build in momentum throughout the story, resulting in a gripping conclusion.",
            "Leisurely paced" => "Due to descriptive language, focus on detail, or careful development of character or setting, these books unfold slowly, allowing the reader to savor the narrative.",
            "Moderate" => "A balanced rhythm where action and introspection alternate evenly, allowing for steady character and plot development.",
            "Episodic" => "The story is told in self-contained chapters or scenes, each contributing to the whole but often varying in tempo.",
            "Unpredictable" => "The pacing shifts unexpectedly—alternating between rapid action and slow introspection—to keep the reader on edge.",
            "Slow-burn" => "The story takes time to develop tension, characters, or romance, rewarding patient readers with a powerful emotional payoff.",
            "Pulse-pounding" => "Relentless action and tension with little room to breathe, creating a constant sense of urgency and danger.",
            "Melancholic Drift" => "The narrative flows gently, often tinged with nostalgia or sadness, encouraging reflective and emotional engagement.",
            "Breathless" => "Barely a pause between events—readers are swept up in a whirlwind of action, twists, and escalating stakes."
        ];
    }
};
