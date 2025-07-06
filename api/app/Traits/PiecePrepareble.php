<?php

namespace App\Traits;

use App\Dtos\Pieces\PieceItem;
use App\Models\Lists\Character;
use App\Models\Lists\Genre;
use App\Models\Lists\Pace;
use App\Models\Lists\Setting;
use App\Models\Lists\Storyline;
use App\Models\Lists\Style;
use App\Models\Lists\Theme;
use App\Models\Lists\Timeline;
use App\Models\Lists\Tone;
use Random\RandomException;
use Spatie\LaravelData\Optional;

trait PiecePrepareble
{
    private int $selectedGenreId = 0;

    private bool $needsTitle = false;

    private array $resultInfo = [];

    private function getGenre(PieceItem $pieceItem): string
    {
        if ($pieceItem->genre_id instanceof Optional || blank($pieceItem->genre_id)) {
            $genre = Genre::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $genre = Genre::where('id', $pieceItem->genre_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->selectedGenreId = $genre->id;
        $this->resultInfo['genre_id'] = $genre->id;

        return "$genre->name, defined as: $genre->description";
    }

    private function getSubGenre(PieceItem $pieceItem): string
    {
        if ($pieceItem->sub_genre_id instanceof Optional || blank($pieceItem->sub_genre_id)) {
            try {
                $genSubGenre = random_int(0, 1);
            } catch (RandomException) {
                $genSubGenre = 0;
            }

            if ($genSubGenre === 0) {
                return '';
            }

            $subGenre = Genre::query()
                ->where('active', true)
                ->where('id', '!=', $this->selectedGenreId)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $subGenre = Genre::where('id', $pieceItem->sub_genre_id)
                ->where('active', true)
                ->where('id', '!=', $this->selectedGenreId)
                ->firstOrFail();
        }

        $this->resultInfo['sub_genre_id'] = $subGenre->id;

        return "\n$subGenre->name, defined as: $subGenre->description";
    }

    private function getSettings(PieceItem $pieceItem): string
    {
        if ($pieceItem->setting_id instanceof Optional || blank($pieceItem->setting_id)) {
            $setting = Setting::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $setting = Setting::where('id', $pieceItem->setting_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['setting_id'] = $setting->id;

        return $setting->name;
    }

    private function getTimeline(PieceItem $pieceItem): string
    {
        if ($pieceItem->timeline_id instanceof Optional || blank($pieceItem->timeline_id)) {
            $timeline = Timeline::query()
                ->where('active', true)
                ->weightedRandom()
                ->firstOrFail();
        } else {
            $timeline = Timeline::where('id', $pieceItem->timeline_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['timeline_id'] = $timeline->id;

        return $timeline->name;
    }

    private function getStoryline(PieceItem $pieceItem): string
    {
        if ($pieceItem->storyline_id instanceof Optional || blank($pieceItem->storyline_id)) {
            $storyline = Storyline::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $storyline = Storyline::where('id', $pieceItem->storyline_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['storyline_id'] = $storyline->id;

        return "$storyline->name, defined as: $storyline->description";
    }

    private function getPace(PieceItem $pieceItem): string
    {
        if ($pieceItem->pace_id instanceof Optional || blank($pieceItem->pace_id)) {
            $pace = Pace::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $pace = Pace::where('id', $pieceItem->pace_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['pace_id'] = $pace->id;

        return "$pace->name, defined as: $pace->description";
    }

    private function getCharacter(PieceItem $pieceItem): string
    {
        if ($pieceItem->character_id instanceof Optional || blank($pieceItem->character_id)) {
            $character = Character::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $character = Character::where('id', $pieceItem->character_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['character_id'] = $character->id;

        return "$character->name, defined as: $character->description";
    }

    private function getTone(PieceItem $pieceItem): string
    {
        if ($pieceItem->tone_id instanceof Optional || blank($pieceItem->tone_id)) {
            $tone = Tone::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $tone = Tone::where('id', $pieceItem->tone_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['tone_id'] = $tone->id;

        return "$tone->name, defined as: $tone->description";
    }

    private function getStyle(PieceItem $pieceItem): string
    {
        if ($pieceItem->style_id instanceof Optional || blank($pieceItem->style_id)) {
            $style = Style::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $style = Style::where('id', $pieceItem->style_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['style_id'] = $style->id;

        return "$style->name, defined as: $style->description";
    }

    private function getTheme(PieceItem $pieceItem): string
    {
        if ($pieceItem->theme_id instanceof Optional || blank($pieceItem->theme_id)) {
            $tone = Theme::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $tone = Theme::where('id', $pieceItem->theme_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['theme_id'] = $tone->id;

        return "$tone->name, defined as $tone->description";
    }
}
