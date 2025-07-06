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
        Schema::create('themes', static function (Blueprint $table): void {
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
        Schema::dropIfExists('themes');
    }

    private function seedTable(): void
    {
        DB::table('themes')->insert([
            ['slug' => 'redemption', 'name' => 'Redemption', 'description' => 'A character seeks to atone for past sins or mistakes, finding peace and transformation through their journey.', 'active' => true],
            ['slug' => 'forbidden-love', 'name' => 'Forbidden Love', 'description' => 'Two people fall in love against cultural, societal, or familial rules, creating intense emotional stakes.', 'active' => true],
            ['slug' => 'betrayal-and-loyalty', 'name' => 'Betrayal and Loyalty', 'description' => 'Explores trust, deception, and the pain of being betrayed by someone close, or the courage to remain loyal under pressure.', 'active' => true],
            ['slug' => 'identity-and-self-discovery', 'name' => 'Identity and Self-Discovery', 'description' => 'The protagonist embarks on a journey—literal or metaphorical—to understand who they truly are.', 'active' => true],
            ['slug' => 'power-and-corruption', 'name' => 'Power and Corruption', 'description' => 'A look at how power changes individuals or societies, often revealing darker sides of human nature.', 'active' => true],
            ['slug' => 'survival-against-all-odds', 'name' => 'Survival Against All Odds', 'description' => 'Characters must overcome extreme challenges—natural disasters, dystopian futures, war, or isolation.', 'active' => true],
            ['slug' => 'revenge', 'name' => 'Revenge', 'description' => 'A character driven by vengeance must wrestle with the consequences of their actions.', 'active' => true],
            ['slug' => 'coming-of-age', 'name' => 'Coming of Age', 'description' => 'Focuses on a young protagonist navigating the transition from youth to adulthood, filled with growth and hardship.', 'active' => true],
            ['slug' => 'the-quest', 'name' => 'The Quest', 'description' => 'A character or group undertakes a perilous journey to achieve a goal, facing trials that transform them.', 'active' => true],
            ['slug' => 'man-vs-nature', 'name' => 'Man vs. Nature', 'description' => 'A struggle against natural forces, highlighting human resilience or insignificance.', 'active' => true],
            ['slug' => 'love-and-sacrifice', 'name' => 'Love and Sacrifice', 'description' => 'Love tested by the need to sacrifice personal desires or even lives for a greater good.', 'active' => true],
            ['slug' => 'good-vs-evil', 'name' => 'Good vs. Evil', 'description' => 'Classic battle between opposing moral forces, often set in fantasy or epic contexts.', 'active' => true],
            ['slug' => 'fear-of-the-unknown', 'name' => 'Fear of the Unknown', 'description' => 'Characters confront supernatural or psychological fears, often exploring horror or mystery.', 'active' => true],
            ['slug' => 'rebellion-and-revolution', 'name' => 'Rebellion and Revolution', 'description' => 'The fight against tyranny or injustice, showing the risks and hope of standing up.', 'active' => true],
            ['slug' => 'justice-and-injustice', 'name' => 'Justice and Injustice', 'description' => 'A focus on moral dilemmas and the gray areas of what is right and fair.', 'active' => true],
            ['slug' => 'time-and-fate', 'name' => 'Time and Fate', 'description' => 'Explores how destiny, time travel, or prophecy shape character lives and decisions.', 'active' => true],
            ['slug' => 'loss-and-grief', 'name' => 'Loss and Grief', 'description' => 'Examines how characters cope with the loss of loved ones or parts of themselves.', 'active' => true],
            ['slug' => 'freedom-and-confinement', 'name' => 'Freedom and Confinement', 'description' => 'Physical, emotional, or societal imprisonment and the longing for liberation.', 'active' => true],
            ['slug' => 'isolation-and-connection', 'name' => 'Isolation and Connection', 'description' => 'Characters in solitude seek or fear relationships, often reflecting internal struggles.', 'active' => true],
            ['slug' => 'hope-and-despair', 'name' => 'Hope and Despair', 'description' => 'Moments when hope is the only light in darkness, or when it\'s nearly extinguished.', 'active' => true],
            ['slug' => 'ambition-and-obsession', 'name' => 'Ambition and Obsession', 'description' => 'Driven characters may reach greatness—or destruction—through relentless pursuit.', 'active' => true],
            ['slug' => 'secrets-and-lies', 'name' => 'Secrets and Lies', 'description' => 'Hidden truths unravel lives, creating suspense and deep emotional fallout.', 'active' => true],
            ['slug' => 'transformation', 'name' => 'Transformation', 'description' => 'Literal or metaphorical changes in characters—body, mind, or soul—drive the plot.', 'active' => true],
            ['slug' => 'war-and-peace', 'name' => 'War and Peace', 'description' => 'Personal and societal conflicts that explore the horrors of war and the healing of peace.', 'active' => true],
            ['slug' => 'artificial-intelligence-and-humanity', 'name' => 'Artificial Intelligence and Humanity', 'description' => 'What it means to be human in an age of thinking machines and digital consciousness.', 'active' => true],
            ['slug' => 'magic-and-reality', 'name' => 'Magic and Reality', 'description' => 'Blends magical elements with real-world settings or dilemmas.', 'active' => true],
            ['slug' => 'alienation-and-belonging', 'name' => 'Alienation and Belonging', 'description' => 'Struggles with fitting in or being an outsider in an unfamiliar or unwelcoming world.', 'active' => true],
            ['slug' => 'memory-and-the-past', 'name' => 'Memory and the Past', 'description' => 'Characters uncover lost or repressed memories, or grapple with haunting pasts.', 'active' => true],
            ['slug' => 'dreams-and-reality', 'name' => 'Dreams and Reality', 'description' => 'Blurred lines between what’s real and imagined, often exploring surreal themes.', 'active' => true],
            ['slug' => 'destiny-vs-free-will', 'name' => 'Destiny vs. Free Will', 'description' => 'The battle between controlling one’s fate or surrendering to a higher power or plan.', 'active' => true],
            ['slug' => 'faith-and-doubt', 'name' => 'Faith and Doubt', 'description' => 'Explores belief—religious, spiritual, or personal—amid trials and skepticism.', 'active' => true],
            ['slug' => 'greed-and-generosity', 'name' => 'Greed and Generosity', 'description' => 'Contrasting human impulses for accumulation or giving, and their impacts.', 'active' => true],
            ['slug' => 'madness-and-sanity', 'name' => 'Madness and Sanity', 'description' => 'A descent into or struggle against mental instability and perception of reality.', 'active' => true],
            ['slug' => 'legacy-and-inheritance', 'name' => 'Legacy and Inheritance', 'description' => 'The weight of what is passed down—material, moral, or cultural—and how it\'s handled.', 'active' => true],
            ['slug' => 'dreams-deferred', 'name' => 'Dreams Deferred', 'description' => 'The pain and consequences of hopes unfulfilled or crushed.', 'active' => true],
            ['slug' => 'technology-and-control', 'name' => 'Technology and Control', 'description' => 'When technology invades privacy, autonomy, or humanity itself.', 'active' => true],
            ['slug' => 'cultural-clash', 'name' => 'Cultural Clash', 'description' => 'Conflicts between different traditions, beliefs, or worlds lead to transformation or tragedy.', 'active' => true],
            ['slug' => 'morality-and-ethics', 'name' => 'Morality and Ethics', 'description' => 'Characters face complex choices where right and wrong are not clear.', 'active' => true],
            ['slug' => 'the-supernatural', 'name' => 'The Supernatural', 'description' => 'Ghosts, spirits, or otherworldly forces affect everyday lives or unravel mysteries.', 'active' => true],
            ['slug' => 'truth-and-perception', 'name' => 'Truth and Perception', 'description' => 'What is real versus what people believe to be true.', 'active' => true],
            ['slug' => 'the-price-of-fame', 'name' => 'The Price of Fame', 'description' => 'The rise and fall of those who crave or stumble into the spotlight.', 'active' => true],
            ['slug' => 'monsters-within', 'name' => 'Monsters Within', 'description' => 'Explores the darkness in human nature or literal internal demons.', 'active' => true],
            ['slug' => 'empires-and-collapse', 'name' => 'Empires and Collapse', 'description' => 'The rise and fall of powerful entities, civilizations, or families.', 'active' => true],
            ['slug' => 'creation-and-destruction', 'name' => 'Creation and Destruction', 'description' => 'A cycle of building something meaningful only for it to be lost—or rebuilt anew.', 'active' => true],
            ['slug' => 'crossroads-and-choices', 'name' => 'Crossroads and Choices', 'description' => 'Pivotal decisions shape entire lives, emphasizing consequence.', 'active' => true],
            ['slug' => 'the-double-life', 'name' => 'The Double Life', 'description' => 'Characters living in dual identities, balancing truth and secrecy.', 'active' => true],
            ['slug' => 'the-outsiders-perspective', 'name' => 'The Outsider’s Perspective', 'description' => 'Told through the eyes of someone alien to the norm—offering insight or critique.', 'active' => true],
            ['slug' => 'small-town-big-secrets', 'name' => 'Small Town, Big Secrets', 'description' => 'Seemingly quiet settings hide dark or bizarre truths.', 'active' => true],
            ['slug' => 'the-road-home', 'name' => 'The Road Home', 'description' => 'A return to one’s origins brings conflict, closure, or rediscovery.', 'active' => true],
            ['slug' => 'endings-and-beginnings', 'name' => 'Endings and Beginnings', 'description' => 'Endings serve as new beginnings, often in cyclical or poetic ways.', 'active' => true],
        ]);
    }
};
