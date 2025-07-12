<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storylines', static function (Blueprint $table) {
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
        Schema::dropIfExists('storylines');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $pace => $description) {
            DB::table('storylines')->insert([
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
            'Action-packed' => 'Pulse-pounding, high-octane excitement is the rule!',
            'Character-driven' => 'Interior growth and development of characters is important.',
            'Intricately Plotted' => 'These books have intricate, complicated, or elaborate storylines.',
            'Issue-oriented' => 'Issue-oriented books explore controversial themes, which may cover emotional, ethical, or social problems.',
            'Nonlinear' => 'Events in these books shift between time periods.',
            'Open-ended' => 'Instead of providing answers, these books invite readers to ponder events long after the last page.',
            'Own Voices' => 'Here the protagonist and the author share a marginalized identity.',
            'Plot-driven' => 'Events rather than characters propel these stories forward.',
            'Sweeping' => 'These sprawling stories span decades or generations and frequently include multiple locations and historical events.',
            'Unconventional' => 'Using unique or unexpected elements, these books may twist, adapt, or play with conventional storylines.',
            'World-building' => 'These books immerse the reader in vivid imaginary worlds of invented histories, languages, geography, or cultures.',
            'Mystery-driven' => 'These stories center around a central puzzle or enigma that the protagonist must solve, often involving crime, secrets, or hidden truths. The narrative unfolds through clues and red herrings, keeping readers guessing until the final reveal.',
            'Romantic' => 'Focused on the development of romantic relationships, these stories explore themes of love, passion, and emotional connection. They often include obstacles that the characters must overcome to be together, leading to heartfelt moments and resolutions.',
            'Survival' => 'In these narratives, characters face extreme situations that test their resilience and resourcefulness. Whether stranded in the wilderness, surviving a disaster, or navigating a post-apocalyptic world, the focus is on the struggle to endure and adapt.',
            'Psychological' => 'These stories delve into the minds of characters, exploring their thoughts, fears, and motivations. Often featuring unreliable narrators or complex mental states, they challenge readers to question reality and the nature of perception.',
            'Historical' => 'Set in a specific historical period, these stories weave factual events and figures into fictional narratives. They provide insight into the past while exploring the lives of characters who navigate the challenges and triumphs of their time.',
            'Fantasy' => 'These tales transport readers to magical realms filled with mythical creatures, epic quests, and supernatural elements. The focus is on the fantastical aspects of the world, often involving battles between good and evil.',
            'Dystopian' => 'Set in a bleak future or oppressive society, these stories explore themes of control, rebellion, and the human spirit. Characters often fight against authoritarian regimes or societal norms, raising questions about freedom and morality.',
            'Slice of Life' => 'These narratives capture everyday moments and experiences, focusing on the mundane aspects of life. They emphasize character interactions and personal growth, often highlighting the beauty in ordinary situations.',
            'Techno-thriller' => 'Combining elements of technology and suspense, these stories often involve high-stakes scenarios related to cyber warfare, espionage, or advanced scientific developments. They explore the implications of technology on society and individual lives, keeping readers on the edge of their seats.',
        ];
    }
};
