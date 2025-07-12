<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Dtos\Pieces\PieceItem;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceType;
use App\Models\Lists\Pov;
use App\Models\Lists\Tense;
use App\Models\Pieces\Piece;
use App\Traits\PiecePrepareble;
use Spatie\LaravelData\Optional;
use Throwable;

final class PieceGeneratePartialAction
{
    use PiecePrepareble;

    public function __construct(private readonly PieceStoreAction $storeAction) {}

    /**
     * @throws Throwable
     */
    public function handle(PieceItem $item, $userId): Piece
    {
        $this->resultInfo = $item->toArray();

        $this->resultInfo['user_id'] = $userId;
        $this->resultInfo['piece_status_id'] = PieceStatus::getDefault();
        $this->resultInfo['target_word_count'] = PieceType::getWordCount($item->piece_type_id);

        $this->getPov($item);
        $this->getTense($item);
        $this->getGenre($item);
        $this->getSubGenre($item);
        $this->getSettings($item);
        $this->getTimeline($item);
        $this->getStoryline($item);
        $this->getPace($item);
        $this->getCharacter($item);
        $this->getTone($item);
        $this->getStyle($item);
        $this->getTheme($item);

        $this->resultInfo['tags'][] = 'Randomized';
        if (is_array($item->tags)) {
            $this->resultInfo['tags'] = array_merge($this->resultInfo['tags'], $item->tags);
        }

        return $this->storeAction->handle(
            PieceItem::from($this->resultInfo),
            $userId
        );
    }

    private function getPov(PieceItem $item): void
    {
        if ($item->pov_id instanceof Optional || blank($item->pov_id)) {
            $pov = Pov::query()
                ->weightedRandom()
                ->firstOrFail();
        } else {
            $pov = Pov::where('id', $item->pov_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['pov_id'] = $pov->id;
    }

    private function getTense(PieceItem $item): void
    {
        if ($item->tense_id instanceof Optional || blank($item->tense_id)) {
            $tense = Tense::query()
                ->weightedRandom()
                ->firstOrFail();
        } else {
            $tense = Tense::where('id', $item->tense_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['tense_id'] = $tense->id;
    }
}
