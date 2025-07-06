<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('styles', static function (Blueprint $table) {
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
        Schema::dropIfExists('styles');
    }

    private function seedTable(): void
    {
        foreach ($this->getData() as $style => $description) {
            DB::table('styles')->insert([
                'slug' => str($style)->slug(),
                'name' => $style,
                'description' => $description,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            'Attention-grabbing' => 'Irresistible to young readers, these books instantly draw them in.',
            'Banter-filled' => 'These books are characterized by snappy repartee.',
            'Candid' => 'The narrative style of these books is frank and forthcoming, even when discussing potentially sensitive or uncomfortable subjects.',
            'Compelling' => 'These powerful books draw readers irresistibly into the story.',
            'Conversational' => 'Written informally, these read as if a close friend were telling a story.',
            'Descriptive' => 'Full of elaborate descriptions, with illustrative, expressive language.',
            'Dialect-filled' => 'Regional lingo and colloquialisms bring the setting to life.',
            'Engaging' => 'These books capture the imagination of readers through narrative style, character, or use of detail.',
            'Gritty' => 'Characterized by a narrative style that includes dark and unsettling details, these books often depict violence.',
            'Incisive' => 'These keenly discerning books cut right to the heart of the matter.',
            'Jargon-filled' => 'These books use the specialized, technical language of a particular group, trade, or profession.',
            'Lush' => 'Descriptive language evokes the senses, making readers feel as if they are experiencing what is being described.',
            'Lyrical' => 'Graceful, beautiful language, often with a rhythmic or poetic quality.',
            'Minimal text' => 'Generally used with young children, these have few words per page. The words tend to be simple, and sentences are short.',
            'Participatory' => 'These books require the reader to engage with the story by answering questions or through physical interaction.',
            'Richly detailed' => 'Details enrich these stories, sometimes focusing on a special body of knowledge (e.g., forensics, music, history, etc.).',
            'Slang-heavy' => 'Characters in these books make frequent use of slang, which often aids in character development.',
            'Spare' => 'Minimal and elegant with great attention paid to the use of language.',
            'Stream of consciousness' => 'These novels and stories portray the uninterrupted and uneven flow of the characters’ consciousness.',
            'Stylistically complex' => 'Due to sophisticated language and narrative structure, these stories can often be read on a number of levels.',
            'Thoughtful' => 'Despite covering a sensitive or controversial topic, these books are considerately written and handle the subject with respect.',
            'Well-crafted dialogue' => 'These books contain authentic or notable dialogue.',
            'Well-researched' => 'The authors of these books demonstrate a deep and knowledgeable understanding of their subject.',
            'Witty' => 'These cleverly written books use language in an inventive, humorous way.',
            'Wordplay-filled' => 'These books are full of puns, palindromes, anagrams, and other clever uses of language.',
        ];
    }
};
