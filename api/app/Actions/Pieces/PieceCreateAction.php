<?php

declare(strict_types=1);

namespace App\Actions\Pieces;

use App\Actions\Listings\CharactersAction;
use App\Actions\Listings\GenresListAction;
use App\Actions\Listings\PacesListAction;
use App\Actions\Listings\PovListAction;
use App\Actions\Listings\PieceStatusesListAction;
use App\Actions\Listings\SettingsListAction;
use App\Actions\Listings\StorylinesListAction;
use App\Actions\Listings\StylesListAction;
use App\Actions\Listings\TenseListAction;
use App\Actions\Listings\ThemesListAction;
use App\Actions\Listings\TimelinesListAction;
use App\Actions\Listings\TonesListAction;
use App\Actions\Listings\PieceTypeListAction;
use App\Actions\Listings\TagsListAction;
use App\Dtos\Pieces\PieceCreateItem;
use App\Models\Pieces\Piece;

final readonly class PieceCreateAction
{
    public function __construct(
        private PieceTypeListAction $typeListAction,
        private PieceStatusesListAction $statusesListAction,
        private PovListAction $povsListAction,
        private TenseListAction $tensesListAction,
        private GenresListAction $genresListAction,
        private TonesListAction $tonesListAction,
        private ThemesListAction $themesListAction,
        private CharactersAction $charactersAction,
        private PacesListAction $pacesListAction,
        private SettingsListAction $settingsListAction,
        private TimelinesListAction $timelineListAction,
        private StorylinesListAction $storylineListAction,
        private StylesListAction $stylesListAction,
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
            characters: $this->charactersAction->handle(),
            paces: $this->pacesListAction->handle(),
            settings: $this->settingsListAction->handle(),
            timelines: $this->timelineListAction->handle(),
            storylines: $this->storylineListAction->handle(),
            style: $this->stylesListAction->handle(),
            tags: $this->tagsListAction->handle(),
        );
    }
}
