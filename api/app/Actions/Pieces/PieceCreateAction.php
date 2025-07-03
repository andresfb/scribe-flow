<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Actions\Listings\PieceGenresListAction;
use App\Actions\Listings\PiecePovListAction;
use App\Actions\Listings\PieceStatusesListAction;
use App\Actions\Listings\PieceTenseListAction;
use App\Actions\Listings\PieceThemesListAction;
use App\Actions\Listings\PieceTonesListAction;
use App\Actions\Listings\PieceTypeListAction;
use App\Actions\Listings\TagsListAction;
use App\Dtos\Pieces\PieceCreateItem;
use App\Models\Pieces\Piece;

final readonly class PieceCreateAction
{
    public function __construct(
        private PieceTypeListAction $typeListAction,
        private PieceStatusesListAction $statusesListAction,
        private PiecePovListAction $povsListAction,
        private PieceTenseListAction $tensesListAction,
        private PieceGenresListAction $genresListAction,
        private PieceTonesListAction $tonesListAction,
        private PieceThemesListAction $themesListAction,
        private TagsListAction $tagsListAction
    ) {}

    /**
     * Execute the action.
     */
    public function handle(int $userId): PieceCreateItem
    {
        $piece = new Piece();
        $piece->user_id = $userId;

        return new PieceCreateItem(
            piece: $piece,
            types: $this->typeListAction->handle(),
            statuses: $this->statusesListAction->handle(),
            povs: $this->povsListAction->handle(),
            tenses: $this->tensesListAction->handle(),
            genres: $this->genresListAction->handle(),
            tones: $this->tonesListAction->handle(),
            themes: $this->themesListAction->handle(),
            tags: $this->tagsListAction->handle(),
        );
    }
}
