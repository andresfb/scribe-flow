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
        Schema::create('genres', static function (Blueprint $table): void {
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
        Schema::dropIfExists('genres');
    }

    private function seedTable(): void
    {
        $this->migrateFromTable();

        $this->importExtras();
    }

    private function migrateFromTable(): void
    {
        $genres = DB::connection('boogie')
            ->table('genres')
            ->get();

        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'slug' => str($genre->title)->slug(),
                'name' => $genre->title,
                'description' => str($genre->description)
                    ->replace('novels', 'stories')
                    ->replace('Novels', 'Stories')
                    ->value(),
                'active' => (bool) $genre->active,
            ]);
        }
    }

    private function importExtras(): void
    {
        foreach ($this->getData() as $genre => $description) {
            $slug = str($genre)->slug();
            if (DB::table('genres')->where('slug', $slug)->exists()) {
                continue;
            }

            DB::table('genres')->insert([
                'slug' => $slug,
                'name' => $genre,
                'description' => $description,
                'active' => true,
            ]);
        }
    }

    private function getData(): array
    {
        return [
            "Absurdism" => "Stories steeped in existential uncertainty, illogical events, and surreal juxtapositions—highlighting the absurd nature of life and human attempts at meaning-making.",
            "Action" => "Fast-paced plots revolving around physical conflict, stunts, chases, and combat—built to thrill and maintain relentless momentum.",
            "Action Horror" => "A hybrid that fuses high-octane action set-pieces with horror elements—often involving supernatural or monstrous threats that protagonists must survive or defeat.",
            "Alternate History" => "These stories imagine how different outcomes arise by changing key historical events—e.g., “What if the South had won the Civil War?”",
            "Biopic" => "Narratives dramatizing the real-life events of a historical or public figure—focusing on pivotal moments and character arcs.",
            "Chivalric Romance" => "Set in medieval-style worlds, featuring knights, quests, courtly love, honor, and chivalry—often involving magical elements or epic deeds.",
            "Comic Literature" => "Primarily humorous fiction—places fun, witty dialogue, satire, or farce at the forefront to entertain and amuse.",
            "Coming of Age Story" => "Focusing on a young protagonist’s transition into adulthood—capturing their emotional maturation and internal growth.",
            "Conspiracy Thriller" => "Centering on shadowy plots by hidden powers (governments, corporations) that protagonists must uncover—tense, suspicion-filled storytelling.",
            "Cosmic Horror" => "Explores humanity\'s insignificance in a universe of vast, uncaring cosmic powers—often invoking madness and existential dread.",
            "Crime Fiction" => "Centered around criminal acts—murder, theft—focusing on investigation, motive, and the criminal mind.",
            "Criminal Procedural" => "Detailed narratives that follow law enforcement’s step-by-step investigations—emphasizing realism and methodology.",
            "Detective Drama" => "Character-rich stories about detectives (amateur or professional) solving crimes—often psychologically nuanced.",
            "Dime Novel" => "Early pulp-style fiction—fast-paced, sensational, cheaply produced adventures from the late 19th–early 20th century.",
            "Erotic Literature" => "Focuses on explicit, sensual narratives and intimate relationships—scenes designed to evoke strong emotional or physical response.",
            "Euroshlock" => "Low-budget European genre films mixing horror, eroticism, gore—reflecting 60s–70s “shock exploitation” cinema.",
            "Fables" => "Short allegorical stories that use animals, mythical creatures, or inanimate objects as characters to convey moral lessons or universal truths.",
            "Fairy Tales" => "Stories featuring magical beings, enchanted settings, and fantastical events—often centered on good versus evil, transformation, and happily-ever-after resolutions.",
            "Folklore" => "Traditional stories, myths, legends, and customs passed orally through generations—reflecting the values, beliefs, and cultural identity of a people.",
            "Fairy Tale" => "Short narratives with moral lessons, mythical creatures, magical transformations—rooted in oral tradition and archetypes.",
            "Folk Horror" => "Horror based on pagan rites, rural landscapes, ancestral superstition—often isolating protagonists in unsettling traditions.",
            "French New Wave" => "Mid-20th‑century cinema movement known for experimental techniques, fragmented narratives, and existential themes.",
            "Gangster Fiction" => "Explores organized crime, criminal underworlds, loyalty, betrayal—often told from within a gang’s perspective.",
            "Genius Thriller" => "Thrillers propelled by exceptional intellect—geniuses solving crimes or outwitting adversaries via extraordinary mental prowess.",
            "Genre Throwback" => "Stories that deliberately evoke nostalgia—reviving conventions of an earlier genre or era in tone and style.",
            "Genre-Busting" => "Fiction that blends or subverts genre conventions—mixing multiple genres to defy audience expectations.",
            "German Expressionism" => "Dark, stylized narratives (especially in early 20th‑century German cinema/literature)—high contrast, symbolic visuals, psychological themes.",
            "Girls with Guns" => "Action-centered stories featuring female protagonists in arms—often martial arts, espionage, or revenge narratives.",
            "Gothic Fiction" => "Dark, brooding settings (castles, manors), elements of horror, romance, suspense, family secrets, supernatural undertones.",
            "Heroic Bloodshed" => "Style of action cinema (notably Hong Kong) marked by stylized violence, honor-bound antiheroes, loyalty themes, and elaborate gunplay.",
            "Heroic Fantasy" => "Fantasy focused on valorous characters, quests, swordplay, hero’s arc—often simpler moral binaries than epic fantasy.",
            "High Fantasy" => "Set in fully imagined worlds (Middle-earth–style), featuring magic, mythical races, grand conflicts between good and evil.",
            "Hillbilly Horrors" => "Horror set in isolated rural Appalachia or Southern backwoods—often featuring cannibals, cults, grotesque locals.",
            "Historical Detective Fiction" => "Crime-solving narratives set in past eras—combining mystery and historical context for rich period atmosphere.",
            "Historical Fantasy" => "Premodern settings infused with magic, mythical creatures—blending historical authenticity and supernatural elements.",
            "Kitchen Sink Drama" => "Gritty realism—depicts domestic, working-class life, personal conflict, social issues in a raw, unglamorous setting.",
            "Legend" => "Epic, often mythic stories rooted in cultural tradition—centering on heroes, supernatural feats, or moral tales.",
            "Literary Mash-Ups" => "Unexpected genre combinations underpinned by literary ambition—for example, gothic + sci‑fi, romance + spy thriller.",
            "Low Fantasy" => "Fantasy set in a recognizable “real world” but with limited magical elements integrated into daily life.",
            "Machinima" => "Narrative films or series created via video-game graphics engines—animation using game assets and characters.",
            "Magical Land" => "Fantasy stories where characters journey to an entirely separate magical realm—often with portals or magical transitions.",
            "Military and Warfare" => "Focused on battles, strategy, soldier experiences—can be historical or fictional, emphasizing conflict and tactics.",
            "Military Science Fiction" => "Sci‑fi centered on futuristic warfare—spaceships, high-tech arms, military hierarchy, and interstellar battles.",
            "Misery Lit" => "Deliberately bleak stories—centered on suffering, trauma, and emotional pain—often extremely raw and unapologetic.",
            "Mundane Fantastic" => "Fantastic settings or magical elements constrained by ordinary, everyday realism—ordinary characters experiencing subtle wonder.",
            "Mythology" => "Collections of traditional stories—gods, creation, heroes, natural phenomena—used to explain and guide cultural values.",
            "New Wave Science Fiction" => "1960s–70s sci-fi stressing literary style, inner space, social issues—moving away from pulp conventions toward experimental narratives.",
            "Ontological Mystery" => "Mysteries not about “who” but “what is real”—often blurring reality, identity, dreams, and perception.",
            "Paranoid Thriller" => "Protagonists confronting conspiracies or hidden enemies—trust is precarious, reality is unstable, tension is psychological.",
            "Period Piece" => "Stories set in a specific historical period—focused on authentic details of time, dress, manners, and atmosphere.",
            "Philosophical Novel" => "Fiction that actively explores philosophical questions—identity, existence, morality—through dialogue and narrative.",
            "Picaresque" => "Series of loosely connected, often comedic adventures—follows a roguish antihero navigating society with wit and mischief.",
            "Pirate Stories" => "Sea-faring adventure featuring pirates, treasure hunts, high seas battles, mutiny, and exotic locales.",
            "Planetary Romance" => "Fantasy/adventure tale set on alien worlds—emphasizes exotic cultures, landscapes, and romantic escapades.",
            "Poverty Porn" => "Depictions of extreme poverty that sensationalize suffering—often criticized as exploitative rather than empathetic.",
            "Prison Films" => "Centered on life inside prisons—conflict, survival, justice, redemption—often gritty and character-driven.",
            "Psychological Horror" => "Uses mental disturbance, paranoia, and distorted perceptions to generate fear—focuses on minds unraveling rather than gore.",
            "Psychological Thriller" => "Intense mind‑games and suspense—focuses on manipulation, identity, mental instability, and character psychology.",
            "Queer Romance" => "Romantic narratives that center LGBTQ+ relationships—exploring identity, love, community, and representation.",
            "Realistic Fiction" => "Set in the real world, featuring plausible characters and events—everyday life and true-to-life dramas.",
            "Riddle" => "Stories structured around puzzles or enigmas that characters solve—often interactive or clever, mirroring the puzzle itself.",
            "Road Trip Plot" => "Narrative that unfolds during a journey—focus on characters’ interactions, growth, discovery, and episodic encounters.",
            "Roadshow Theatrical Release" => "A stylized theatrical format prevalent mid-20th-century—feature-length films with overture, intermission, and souvenir programs.",
            "Roger Rabbit Effect" => "Narratives where animated characters and live-action actors coexist—blurring the boundary between drawing and live world.",
            "Romantic Comedy" => "Lighthearted romance with humorous situations—centers on lovers who encounter comedic obstacles and ultimately wind up together.",
            "Sacred Literature" => "Texts with religious or spiritual authority—scriptures, parables, devotional stories conveying spiritual teachings or moral lessons.",
            "School Stories" => "Set in academic settings—boarding schools, universities—typically featuring coming-of-age, friendship, rivalry, and youthful growth.",
            "Sea Stories" => "Tales set at sea—naval life, merchant sailing, sea monsters, storms—focusing on adventure, survival, and maritime culture.",
            "Sex Comedy" => "Humorous narratives revolving around sexual situations, misunderstandings, and romantic entanglements—often risqué and playful.",
            "Slice of Life" => "Depicts ordinary, everyday experiences—low stakes, character-driven, often reflective or intimate in tone.",
            "Space Opera" => "Grand, epic science fiction with galaxy-spanning conflicts, large casts, heroic characters, and futuristic tech.",
            "Speculative Fiction" => "Umbrella term that includes sci-fi, fantasy, alternate history—stories that explore worlds different from our known reality.",
            "Spy Literature" => "Centered on espionage, intelligence agencies, undercover operations, betrayal—focus on secrets and global stakes.",
            "Superhero Literature" => "Stories featuring heroic figures with superpowers or unusual abilities—fighting villains and upholding justice.",
            "Supernatural Fiction" => "Features ghosts, spirits, magical entities, unexplainable phenomena—often eerie, mysterious, or symbolic.",
            "Swashbuckler" => "Adventure stories with daring feats, swordplay, flamboyant heroes, and high-seas or historical action.",
            "Sword and Sandal" => "Epics set in ancient classical worlds—like Rome or Greece—featuring warriors, deities, and grand-scale battles.",
            "Sword and Sorcery" => "Fantasy focusing on personal heroics, sword fights, magic, and gritty adventures in smaller settings than epics.",
            "The Epic" => "Large-scale narratives chronicling generations or vast events—mythic in scope, with sweeping themes and deep worldbuilding.",
            "Torture Porn" => "Extreme horror relying on graphic violence and prolonged suffering—intended to shock and disturb.",
            "Tragedy" => "Literary works where the protagonist suffers downfall due to flaw, fate, or circumstance—evoke pathos and moral contemplation.",
            "Tragicomedy" => "Blends tragic and comic elements—serious or sad events interwoven with humor, often ending ambiguously.",
            "True Crime" => "Nonfiction or fictionalized accounts focused on real-life crimes—explores investigations, criminals, victims, and justice.",
            "Two-Fisted Tales" => "Hard‑boiled adventure/action stories—tough protagonists, fast-paced, often set in rugged American or exotic locales.",
            "Urban Fantasy" => "Fantasy set in contemporary cities—supernatural elements hidden within everyday modern life.",
            "Vacation Films" => "Light, often comedic stories centered on holidays, travel, or resort settings—focused on relaxation, family dynamics, or romance.",
            "Western Literature" => "Stories set in the American Old West—cowboys, outlaws, frontier justice, wide-open landscapes, moral ruggedness.",
            "Wooden Ships and Iron Men" => "Naval historical stories set during the Age of Sail—focusing on ship life, maritime strategy, discipline, and naval conflict.",
            "Xenofiction" => "Fiction told from the viewpoint of nonhuman intelligences—aliens, animals, extraterrestrials—presenting radically different perspectives.",
        ];
    }
};
