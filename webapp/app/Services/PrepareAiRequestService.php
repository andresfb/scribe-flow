<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use App\Dtos\Pieces\PieceItem;
use App\Factories\ContentGeneratorFactory;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceType;
use App\Traits\PiecePrepareble;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Spatie\LaravelData\Optional;

final class PrepareAiRequestService
{
    use PiecePrepareble;

    public function __construct(private readonly ContentGeneratorFactory $contentAiFactory) {}

    /**
     * @throws Exception
     */
    public function execute(GeneratorRequest $generator): PromptItem
    {
        Log::notice("Generating the prompt for a {$generator->type->value} piece");

        $pieceItem = PieceItem::from($generator->request);

        $prompt = str($this->getBasePrompt($generator->type->value))
            ->replace('<<TYPE>>', $this->getType($pieceItem))
            ->replace('<<WORDS>>', $this->getWordLimit())
            ->replace('<<TITLE>>', $this->getTitle($pieceItem))
            ->replace('<<GENRE>>', $this->getGenre($pieceItem))
            ->replace('<<SUB_GENRE>>', $this->getSubGenre($pieceItem))
            ->replace('<<SETTING>>', $this->getSettings($pieceItem))
            ->replace('<<TIMELINE>>', $this->getTimeline($pieceItem))
            ->replace('<<STORYLINE>>', $this->getStoryline($pieceItem))
            ->replace('<<PACE>>', $this->getPace($pieceItem))
            ->replace('<<CHARACTER>>', $this->getCharacter($pieceItem))
            ->replace('<<TONE>>', $this->getTone($pieceItem))
            ->replace('<<STYLE>>', $this->getStyle($pieceItem))
            ->replace('<<THEME>>', $this->getTheme($pieceItem))
            ->replace('<<TITLE_TEMPLATE>>', $this->getTitleTemplate())
            ->trim()
            ->value();

        $promptItem = PromptItem::from([
            'prompt' => $prompt,
            'pieceItem' => PieceItem::from($this->resultInfo),
        ]);

        return $this->contentAiFactory->execute($promptItem);
    }

    private function getBasePrompt(string $requestType): string
    {
        $requestType = mb_strtolower($requestType);

        return Config::string("prompts.$requestType.text");
    }

    private function getType(PieceItem $pieceItem): string
    {
        if ($pieceItem->piece_type_id instanceof Optional || blank($pieceItem->piece_type_id)) {
            throw new InvalidArgumentException('Piece type is required');
        }

        $type = PieceType::where('id', $pieceItem->piece_type_id)
            ->where('active', true)
            ->where('randomizable', true)
            ->firstOrFail();

        $this->resultInfo['piece_type_id'] = $type->id;

        return $type->name;
    }

    private function getTitle(PieceItem $pieceItem): string
    {
        if ($pieceItem->title instanceof Optional || blank($pieceItem->title)) {
            $this->needsTitle = true;

            return Config::string('prompts.idea.title');
        }

        $this->resultInfo['title'] = $pieceItem->title;

        return sprintf(' titled: "%s"', $pieceItem->title);
    }

    private function getTitleTemplate(): string
    {
        return $this->needsTitle
            ? Config::string('prompts.idea.title_template')
            : '';
    }

    private function getWordLimit(): string
    {
        return (string) Config::integer('prompts.idea.words_limit');
    }
}
