<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dtos\Pieces\PieceStoreItem;
use App\Enums\GeneratorStatus;
use App\Enums\GeneratorType;
use App\Models\GeneratorRequest;
use App\Models\Lists\Genre;
use App\Models\Lists\Pov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\Tense;
use App\Models\Lists\Theme;
use App\Models\Lists\Tone;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use App\Services\GeneratorContentService;
use Exception;
use Illuminate\Console\Command;
use Throwable;

use function Laravel\Prompts\clear;

final class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Tests runner';

    public function handle(GeneratorContentService $service): void
    {
        clear();

        try {
            $this->info("\nStarting at: ".now()."\n");

            $item = PieceStoreItem::from([
                'piece_type_id' => 3, // short story
            ]);

            $request = GeneratorRequest::create([
                'user_id' => 1,
                'status' => GeneratorStatus::REQUESTED,
                'type' => GeneratorType::IDEA,
                'request' => $item->toArray(),
            ]);

            $service->execute($request->id);
        } catch (Throwable $e) {
            $this->error("\nError Testing");
            $this->error($e->getMessage().PHP_EOL);
        } finally {
            $this->info("\nDone at: ".now()."\n");
        }
    }

    /**
     * @throws Exception
     */
    public function populate(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Piece::factory()
                ->hasTags(random_int(1, 5))
                ->create([
                    'user_id' => 1,
                    'piece_type_id' => PieceType::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_status_id' => PieceStatus::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'pov_id' => Pov::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'tense_id' => Tense::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'genre_id' => Genre::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'sub_genre_id' => Genre::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'tone_id' => Tone::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'theme_id' => Theme::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                ]);

            echo '.';
        }
    }
}
