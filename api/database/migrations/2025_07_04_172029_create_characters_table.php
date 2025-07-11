<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', static function (Blueprint $table) {
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
        Schema::dropIfExists('characters');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $character => $description) {
            DB::table('characters')->insert([
                'slug' => str($character)->slug(),
                'name' => $character,
                'description' => $description,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            'Ability diverse' => 'These characters live with physical, mental, or emotional conditions that can often be challenging.',
            'Anthropomorphic' => 'From cats solving mysteries to crayons quitting their day jobs, the non-human characters in these books offer a unique perspective.',
            'Authentic' => 'These characters behave in ways that accord with their age, nationality, and backgrounds.',
            'Awkward' => 'Often unsure of themselves, these characters lack the social savvy to navigate relationships and other interpersonal situations smoothly.',
            'Believable' => 'These characters ring true for young readers, and behave in ways that are consistent with their age and backgrounds.',
            'Brooding' => 'Haunted by past traumas or mistakes, these morose characters contemplate (and often must confront) what is wrong in the world.',
            'Character duos' => 'From best friends to odd couples, these books feature dynamic duos who take on the world together!',
            'Complex' => 'Intriguing and complicated, these multi-dimensional characters have conflicting motivations and desires.',
            'Courageous' => 'These brave and often self-sacrificing characters have strong convictions and face challenges with determination, despite the odds against them.',
            'Culturally diverse' => 'These books may feature characters from racial and ethnic minorities living in the United States, Europe, Canada, or Australia, as well as characters from non-white cultural groups living in other parts of the world.',
            'Exaggerated' => 'These larger-than-life characters often delight readers by adding to the humor or uniqueness of a story.',
            'Flawed' => 'These characters do not always act in their own best interests, and their sometimes misguided decisions form a central theme in the story.',
            'Introspective' => 'These characters examine their own feelings, thoughts, and motives, and what they find often has major repercussions for the story.',
            'Large cast of characters' => 'Whether because of sprawling storylines, epic scopes, or intricate plots, these books contain lots of characters — how well readers get to know them depends on the author.',
            'LGBTQIA diverse' => 'Identifying as lesbian, gay, bisexual, transgender, queer, intersex, asexual, or questioning, these characters are not stereotypes and are important to the story (even if in a secondary role).',
            'Likeable' => 'These appealing characters engage readers and are likeable, despite flaws.',
            'Mischievous' => 'These child characters frequently get into trouble or cause minor disasters due to their curiosity or intentional disregard for the rules.',
            'Quirky' => 'Eccentric and idiosyncratic, these characters range from peculiar to bizarre, and generally add to the charm or humor of the stories in which they appear.',
            'Relatable' => 'Because their emotions and experiences are recognizable, readers are able to identify with these characters and their dilemmas.',
            'Religiously diverse' => 'These characters follow or have a background in a religion other than Christianity. While their active level of involvement in the religion may vary, the character’s religious beliefs are an important element in the story.',
            'Sarcastic' => 'These young characters sometimes employ sarcasm for humor, and sometimes in response to difficult or challenging situations.',
            'Sassy' => 'These books feature characters (usually women) with outsized personalities and a bottomless well of one-liners and comebacks.',
            'Snarky' => 'These characters employ sarcasm, irony, and biting wit in their approach to life (and often have fun with it!).',
            'Spirited' => 'These lively characters are full of energy and vigor.',
            'Spunky' => 'Feisty and scrappy, these characters have pluck and determination.',
            'Strong female' => 'Whether catching criminals or saving the world, these take-charge women and girls are at the top of their game.',
            'Sympathetic' => 'While sometimes dealing with difficult situations or making poor decisions, these characters are presented in such a way that readers empathize with them.',
            'Twisted' => 'Deviant and often unsettling, these characters push the boundaries of literature through behavior that ranges from disturbing to illegal.',
            'Unlikeable' => 'Deliberately painted in an unflattering light, these characters will not gain the sympathy of readers, so there is less emotional investment if and when bad things happen to them.',
            'Well-developed' => 'Sometimes appearing in more plot-driven stories, these characters rise above others in the strength of their development.',
        ];
    }
};
