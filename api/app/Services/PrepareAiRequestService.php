<?php

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
use InvalidArgumentException;
use Random\RandomException;
use Spatie\LaravelData\Optional;

final class PrepareAiRequestService
{
    private int $selectedGenreId = 0;

    private bool $hasTitle = false;

    private array $resultInfo = [];

    public function __construct(private readonly ContentGeneratorFactory $contentAiFactory){}

    /**
     * @throws Exception
     */
    public function execute(GeneratorRequest $generator): PromptItem
    {
        $pieceItem = PieceStoreItem::from($generator->request);

        $prompt = str($this->getBasePrompt($generator->type->value))
            ->append(
                $this->getType($pieceItem)
            )
            ->append(
                $this->getTitle($pieceItem)
            )
            ->append(
                $this->getGenre($pieceItem)
            )
            ->append(
                $this->getSubGenre($pieceItem)
            )
            ->append(
                $this->getTone($pieceItem)
            )
            ->append(
                $this->getTheme($pieceItem)
            )
            ->append(
                $this->getSettings($pieceItem)
            )
            ->append(
                $this->getPromptConditions()
            )
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
            return '';
        }

        $this->resultInfo['title'] = $pieceItem->title;
        $this->hasTitle = true;

        return Config::string('prompts.pieces.title');
    }

    private function getType(PieceStoreItem $pieceItem): string
    {
        if ($pieceItem->piece_type_id instanceof Optional || blank($pieceItem->piece_type_id)) {
            throw new InvalidArgumentException('Piece is required');
        }

        $type = PieceType::where($pieceItem->piece_type_id)
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
        $genre = PieceGenre::where($pieceItem->piece_genre_id)
            ->where('active', true)
            ->first();

        if ($genre === null) {
            $genre = PieceGenre::query()
                ->where('active', true)
                ->inRandomOrder()
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
        $subGenre = PieceGenre::where($pieceItem->piece_sub_genre_id)
            ->where('id', '!=', $this->selectedGenreId)
            ->where('active', true)
            ->first();

        if ($subGenre === null) {
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
        }

        $this->resultInfo['piece_sub_genre_id'] = $subGenre->id;

        return sprintf(
            Config::string('prompts.pieces.sub_genre'),
            $subGenre->name,
        );
    }

    private function getTone(PieceStoreItem $pieceItem): string
    {
        $tone = PieceTone::where($pieceItem->piece_tone_id)
            ->where('active', true)
            ->first();

        if ($tone === null) {
            $tone = PieceTone::query()
                ->where('active', true)
                ->inRandomOrder()
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
        $tone = PieceTheme::where($pieceItem->piece_theme_id)
            ->where('active', true)
            ->first();

        if ($tone === null) {
            $tone = PieceTheme::query()
                ->where('active', true)
                ->inRandomOrder()
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
        $settings = str();
        if ($pieceItem->setting_time_period instanceof Optional || blank($pieceItem->setting_time_period)) {
            $settings = $settings->append(
                Config::string('prompts.pieces.settings.time_period'),
                $pieceItem->setting_time_period,
            );

            $this->resultInfo['setting_time_period'] = $pieceItem->setting_time_period;
        }

        if ($pieceItem->setting_location instanceof Optional || blank($pieceItem->setting_location)) {
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
            $this->hasTitle
                ? Config::string('prompts.pieces.endings.title_template')
                : '',
        );
    }
}
