<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Lists\PiecePov;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceTense;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use Exception;
use Illuminate\Console\Command;
use function Laravel\Prompts\clear;

final class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Tests runner';

    public function handle(): void
    {
        clear();

        try {
            $this->info("\nStarting at: ".now()."\n");

            Piece::factory()
                ->count(5)
                ->hasTags(4)
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
                ]);

            return;
        } catch (Exception $e) {
            $this->error("\nError Testing");
            $this->error($e->getMessage().PHP_EOL);
        } finally {
            $this->info("\nDone at: ".now()."\n");
        }
    }
}
