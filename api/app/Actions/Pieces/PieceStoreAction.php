<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Dtos\Pieces\PieceItem;
use App\Models\Lists\PieceStatus;
use App\Models\Pieces\Piece;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

final readonly class PieceStoreAction
{
    /**
     * @throws Throwable
     */
    public function handle(PieceItem $item, int $userId): Piece
    {
        $slug = str($item->title)
            ->append(" $userId")
            ->slug();

        if (Piece::where('slug', $slug)->exists()) {
            throw new RuntimeException("Piece \"$item->title\" already exists", 409);
        }

        return DB::transaction(static function () use ($item, $userId): Piece {
            $data = $item->toArray();
            $data['user_id'] = $userId;
            $data['piece_status_id'] = PieceStatus::getDefault();
            unset($data['tags'], $data['slug']);

            $piece = Piece::create($data);
            $piece->attachTags($item->tags);

            return $piece;
        });
    }
}
