<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Dtos\Pieces\PieceStoreItem;
use App\Enums\GeneratorStatus;
use App\Enums\GeneratorType;
use App\Jobs\GenerateContentJob;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceType;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

final readonly class PieceGenerateAction
{
    /**
     * @throws Throwable
     */
    public function handle(PieceStoreItem $item, int $userId): int
    {
        return DB::transaction(static function () use($item, $userId) : int {
            $pieceType = PieceType::where('id', $item->piece_type_id)
                ->where('active', true)
                ->firstOrFail();

            if (! $pieceType->randomizable) {
                throw new RuntimeException("$pieceType->name cannot generate content", 406);
            }

            $request = GeneratorRequest::create([
                'user_id' => $userId,
                'status' => GeneratorStatus::REQUESTED,
                'type' => GeneratorType::SYNOPSIS,
                'request' => $item->toArray(),
            ]);

            GenerateContentJob::dispatch($request->id)
                ->onQueue('ai')
                ->delay(now()->addSeconds(10));

            return $request->id;
        });
    }
}
