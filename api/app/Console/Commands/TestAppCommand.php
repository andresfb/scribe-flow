<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dtos\Pieces\PieceStoreItem;
use App\Enums\GeneratorStatus;
use App\Enums\GeneratorType;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceGenre;
use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceTheme;
use App\Models\Lists\PieceTone;
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
                'type' => GeneratorType::SYNOPSIS,
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
                    'piece_pov_id' => PiecePov::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_tense_id' => PieceTense::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_genre_id' => PieceGenre::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_sub_genre_id' => PieceGenre::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_tone_id' => PieceTone::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                    'piece_theme_id' => PieceTheme::where('active', true)
                        ->inRandomOrder()
                        ->first()
                        ->id,
                ]);

            echo '.';
        }
    }
}
