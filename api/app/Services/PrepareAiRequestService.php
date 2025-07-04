<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use App\Dtos\Pieces\PieceStoreItem;
use App\Factories\ContentGeneratorFactory;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceGenre;
use App\Models\Lists\PieceTheme;
use App\Models\Lists\PieceTone;
use App\Models\Lists\PieceType;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Random\RandomException;
use Spatie\LaravelData\Optional;

final class PrepareAiRequestService
{
    private int $selectedGenreId = 0;

    private bool $needsTitle = false;

    private array $resultInfo = [];

    public function __construct(private readonly ContentGeneratorFactory $contentAiFactory) {}

    /**
     * @throws Exception
     */
    public function execute(GeneratorRequest $generator): PromptItem
    {
        Log::notice("Generating the prompt for a {$generator->type->value} piece");

        $pieceItem = PieceStoreItem::from($generator->request);

        $prompt = Str::of($this->getBasePrompt($generator->type->value))
            ->append($this->getType($pieceItem))
            ->append($this->getTitle($pieceItem))
            ->append($this->getGenre($pieceItem))
            ->append($this->getSubGenre($pieceItem))
            ->append($this->getTone($pieceItem))
            ->append($this->getTheme($pieceItem))
            ->append($this->getSettings($pieceItem))
            ->append($this->getPromptConditions())
            ->trim()
            ->value();

        $promptItem = PromptItem::from([
            'prompt' => $prompt,
            'pieceItem' => PieceStoreItem::from($this->resultInfo),
        ]);

        return $this->contentAiFactory->execute($promptItem);
    }

    private function getBasePrompt(string $requestType): string
    {
        $requestType = mb_strtolower($requestType);

        return sprintf(
            Config::string('prompts.pieces.base'),
            $requestType,
            Config::integer("prompts.pieces.limits.words.$requestType"),
        );
    }

    private function getTitle(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->title instanceof Optional || blank($pieceItem->title)) {
            $this->needsTitle = true;

            return Config::string('prompts.pieces.title');
        }

        $this->resultInfo['title'] = $pieceItem->title;

        return '';
    }

    private function getType(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_type_id instanceof Optional || blank($pieceItem->piece_type_id)) {
            throw new InvalidArgumentException('Piece is required');
        }

        $type = PieceType::where('id', $pieceItem->piece_type_id)
            ->where('active', true)
            ->where('randomizable', true)
            ->firstOrFail();

        $this->resultInfo['piece_type_id'] = $type->id;

        return sprintf(
            Config::string('prompts.pieces.type'),
            $type->name,
        );
    }

    private function getGenre(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_genre_id instanceof Optional || blank($pieceItem->piece_genre_id)) {
            $genre = PieceGenre::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $genre = PieceGenre::where('id', $pieceItem->piece_genre_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->selectedGenreId = $genre->id;
        $this->resultInfo['piece_genre_id'] = $genre->id;

        return sprintf(
            Config::string('prompts.pieces.genre'),
            $genre->name,
            $genre->description
        );
    }

    private function getSubGenre(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_sub_genre_id instanceof Optional || blank($pieceItem->piece_sub_genre_id)) {
            try {
                $genSubGenre = random_int(0, 1);
            } catch (RandomException) {
                $genSubGenre = 0;
            }

            if ($genSubGenre === 0) {
                return '';
            }

            $subGenre = PieceGenre::query()
                ->where('active', true)
                ->where('id', '!=', $this->selectedGenreId)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $subGenre = PieceGenre::where('id', $pieceItem->piece_sub_genre_id)
                ->where('active', true)
                ->where('id', '!=', $this->selectedGenreId)
                ->firstOrFail();
        }

        $this->resultInfo['piece_sub_genre_id'] = $subGenre->id;

        return sprintf(
            Config::string('prompts.pieces.sub_genre'),
            $subGenre->name,
            $subGenre->description,
        );
    }

    private function getTone(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_tone_id instanceof Optional || blank($pieceItem->piece_tone_id)) {
            $tone = PieceTone::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $tone = PieceTone::where('id', $pieceItem->piece_tone_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['piece_tone_id'] = $tone->id;

        return sprintf(
            Config::string('prompts.pieces.tone'),
            $tone->name,
            $tone->description
        );
    }

    private function getTheme(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_theme_id instanceof Optional || blank($pieceItem->piece_theme_id)) {
            $tone = PieceTheme::query()
                ->where('active', true)
                ->inRandomOrder()
                ->firstOrFail();
        } else {
            $tone = PieceTheme::where('id', $pieceItem->piece_theme_id)
                ->where('active', true)
                ->firstOrFail();
        }

        $this->resultInfo['piece_theme_id'] = $tone->id;

        return sprintf(
            Config::string('prompts.pieces.theme'),
            $tone->name,
            $tone->description
        );
    }

    private function getSettings(PieceStoreItem $pieceItem): string
    {
        $settings = Str::of('');
        if (! $pieceItem->setting_time_period instanceof Optional && ! blank($pieceItem->setting_time_period)) {
            $settings = $settings->append(
                Config::string('prompts.pieces.settings.time_period'),
                $pieceItem->setting_time_period,
            );

            $this->resultInfo['setting_time_period'] = $pieceItem->setting_time_period;
        }

        if (! $pieceItem->setting_location instanceof Optional && ! blank($pieceItem->setting_location)) {
            $settings = $settings->append(
                Config::string('prompts.pieces.settings.location'),
                $pieceItem->setting_location,
            );

            $this->resultInfo['setting_location'] = $pieceItem->setting_location;
        }

        return $settings->value();
    }

    private function getPromptConditions(): string
    {
        return sprintf(
            Config::string('prompts.pieces.endings.base'),
            $this->needsTitle
                ? Config::string('prompts.pieces.endings.title_template')
                : '',
        );
    }
}
