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
        Schema::create('tones', static function (Blueprint $table): void {
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
        Schema::dropIfExists('tones');
    }

    private function seedTable(): void
    {
        $this->migrateFromTable();

        $this->importExtras();
    }

    private function migrateFromTable(): void
    {
        $genres = DB::connection('boogie')
            ->table('tones')
            ->get();

        foreach ($genres as $genre) {
            DB::table('tones')->insert([
                'slug' => str($genre->title)->slug(),
                'name' => $genre->title,
                'description' => $genre->description,
                'active' => (bool) $genre->active,
            ]);
        }
    }

    private function importExtras(): void
    {
        foreach ($this->getData() as $tone => $description) {
            $slug = str($tone)->slug();
            if (DB::table('tones')->where('slug', $slug)->exists()) {
                continue;
            }

            DB::table('tones')->insert([
                'slug' => $slug,
                'name' => $tone,
                'description' => $description,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            'Amusing' => 'They may not make you laugh out loud, but these stories have a light humor that sometimes accentuates more serious themes.',
            'Angst-filled' => 'Characters in these books experience problems associated with adolescence, such as questions about sexuality, popularity, or social standing.',
            'Atmospheric' => 'These books evoke the story’s setting, whether it’s a gothic mansion or a small Midwestern town.',
            'Bittersweet' => 'A mixed emotional edge — both pleasant and painful — that is sustained throughout the story.',
            'Bleak' => 'A dark outlook, frequently devoid of faith in human nature and tending away from hope or optimism.',
            'Chaste' => 'These books about romantic relationships focus on the emotions of the characters, and contain no sex or descriptions of sexual activity.',
            'Creepy' => 'Unsettling in a visceral, skin-crawling way, these books make the reader uneasy, and may often have supernatural elements and eerie settings.',
            'Darkly Humorous' => 'The humor in these books derives from ironic or grimly satiric treatment of death, suffering, and other morbid subjects.',
            'Disturbing' => 'Approaching the darker side of human nature, these books are unsettling and often portray socially marginalized or dysfunctional individuals.',
            'Dramatic' => 'These cinematic books feature exciting and larger-than-life stories, depicting anything from historical events to space warfare.',
            'Emotionally intense' => 'Conveying great depth or complexity of emotion, these books explore the inner lives of characters in detail.',
            'Explicit' => 'These books contain lots of vividly described sex, ranging from the plainest (but plentiful) vanilla to the kinkiest of kink.',
            'Feel-good' => 'A gentle, comfortable, and hopeful feeling (not just a happy ending).',
            'Funny' => 'Laugh-out-loud humor characterizes these books.',
            'Gossipy' => 'Actions and people tend to be over-the-top and salacious.',
            'Gross' => 'Yuck! Including lots of nasty, oozy, or disgusting facts or details, these books may be educational or purely for entertainment.',
            'Gruesome' => 'Not for the squeamish, these books include a significant amount of explicit gore or other grisly elements.',
            'Haunting' => 'Often because of hard-hitting storylines, these books have a memorable, unforgettable quality that stays with the reader.',
            'Heartwarming' => 'These uplifting stories ultimately leave readers feeling emotionally satisfied.',
            'Heartwrenching' => 'These books convey emotions that are keenly distressing, hitting a nerve with readers and deeply affecting them.',
            'High-drama' => 'Juicy, sensational, and melodramatic, these books portray back-stabbing social scenes and catty personalities.',
            'Homespun' => 'Simplicity is key, often with a rural or small-town setting and characters who are unpretentious and cherish old-fashioned values.',
            'Hopeful' => 'While addressing weighty issues, these books incorporate some optimistic elements, expressing the belief that things may improve.',
            'Inspiring' => 'These books have an enlightening or uplifting quality, which may or may not be religious in nature.',
            'Irreverent' => 'No institutions, people, or beliefs are off-limits in these humorous (and sometimes subversive) books.',
            'Melancholy' => 'While not grim or hopeless, these books are sad, somber, or gloomy. ',
            'Menacing' => 'A sense of threat or menace pervades, evoking feelings of dread.',
            'Mildly Sensuous' => 'Sex is present, but it’s not given pride of place. Relationships are most important, but sometimes characters act on their attractions.',
            'Moody' => 'A dark and brooding tone that borders on melodrama.',
            'Moving' => 'Emotionally resonant books that make readers feel invested in both the characters and the story.',
            'Mystical' => 'Touching on spiritual themes, these books often explore archetypes and incorporate metaphysical events.',
            'Noisy' => 'Because of rousing, energetic pictures or text, these stories lend themselves to loud readings.',
            'Nostalgic' => 'Characters reminisce, or the book looks back toward a particular place or time with longing and wistfulness.',
            'Offbeat' => 'Through plot twists, bizarre humor, and unique personalities, these quirky books recount unconventional, idiosyncratic, or unusual stories.',
            'Patriotic' => 'These books celebrate and show pride in one’s country and its achievements. ',
            'Quiet' => 'Soothing, low-key stories that have a calming effect on young readers.',
            'Racy humor' => 'Including coarse or risqué material; these books refer to sex in a humorous way.',
            'Reflective' => 'Contemplative books featuring characters who think seriously about their lives and place in the world.',
            'Romantic' => 'These books feature strong romantic elements — either between characters or in the story itself. Happy endings not guaranteed!',
            'Sad' => 'Issues in these books may be very serious (such as death), or less serious but still challenging (such as a friend moving away).',
            'Sardonic' => 'Dry humor and biting wit set the tone in these stories.',
            'Scary' => 'These spooky books have a frightening or menacing feeling that will make young readers uneasy. ',
            'Serious' => 'Marked by seriousness, gravity, or solemnity, these books confront social issues such as war, poverty, gender, or racial concerns.',
            'Silly' => 'The class clowns of literature, these books are often quite absurd and ridiculous but lots of fun.',
            'Sobering' => 'Addressing weighty social issues, these serious and hard-hitting books present a perspective that may be revelatory to the reader.',
            'Steamy' => 'In adult books, the sex is pretty vivid and goes beyond just innuendo. In teen books, there is still an unmistakably sexy aura, although perhaps not as much graphic detail.',
            'Strong sense of place' => 'Powerfully depicted locales — real or imaginary — come alive and give a good sense of what makes a place unique.',
            'Suspenseful' => 'Ranging in intensity from subtle psychological unease to nail-biting suspense, these books keep readers on edge.',
            'Sweet' => 'With a light tone and appealing innocence, these endearing books are cute, playful, and otherwise delightful.',
            'Thought-provoking' => 'More than just telling a story, these books take on big ideas — anything from philosophical quandaries to time paradoxes.',
            'Upbeat' => 'These fun books are lighthearted, hopeful, and optimistic.',
            'Violent' => 'Not for the faint of heart, these books contain explicit or graphic violence.',
            'Whimsical' => 'These fanciful and playful books will charm and enchant readers, and often include fairy tales or other elements of fantasy.',
        ];
    }
};
