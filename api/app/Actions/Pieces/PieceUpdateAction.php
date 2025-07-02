<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Dtos\Pieces\PieceStoreItem;
use App\Models\Pieces\Piece;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

final readonly class PieceUpdateAction
{
    public function __construct(public PieceGetAction $getAction) {}

    /**
     * @throws Throwable
     */
    public function handle(Piece $model, PieceStoreItem $item): Piece
    {
        DB::transaction(static function () use ($model, $item): void {
            $data = $item->toArray();

            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $updated = $model->update($data);
            if (! $updated) {
                throw new RuntimeException("Could not update piece", 406);
            }

            $model->syncTags($tags);
        });

        return $this->getAction->handle($model->slug, $model->user_id);
    }
}
