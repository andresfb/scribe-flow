<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use App\Enums\GeneratorStatus;
use App\Events\ContentGeneratedEvent;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceType;
use App\Models\Lists\Pov;
use App\Models\Lists\Tense;
use App\Models\Pieces\Piece;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Text\Response;
use RuntimeException;
use Throwable;

final class GeneratorContentService
{
    private GeneratorRequest $request;

    public function __construct(
        private readonly PrepareAiRequestService $prepareService,
        private readonly GeneratorAiService $aiService,
    ) {}

    /**
     * @throws Throwable
     */
    public function execute(int $requestId): void
    {
        $output = null;
        $promptItem = null;
        $this->request = GeneratorRequest::query()
            ->where('id', $requestId)
            ->firstOrFail();

        try {
            $promptItem = $this->prepareService->execute($this->request);
            $output = $this->aiService->generate($promptItem);

            if (blank($output->text)) {
                throw new RuntimeException('No text returned from AI');
            }

            $outputText = str($output->text)
                ->replace('`', '')
                ->replace('json', '')
                ->value();

            $content = json_decode($outputText, true, 512, JSON_THROW_ON_ERROR);

            DB::transaction(function () use ($content, $output, $promptItem): void {
                $data = $promptItem->pieceItem->toArray();
                $data['user_id'] = $this->request->user_id;
                $data['idea'] = $content['content'];
                $data['piece_status_id'] = PieceStatus::getDefault();
                $data['pov_id'] = Pov::weightedRandom()->first()->id ?? null;
                $data['tense_id'] = Tense::weightedRandom()->first()->id ?? null;
                $data['target_word_count'] = PieceType::getWordCount($promptItem->pieceItem->piece_type_id);

                if (isset($content['title'])) {
                    $data['title'] = $content['title'];
                }

                $piece = Piece::create($data);
                $piece->attachTags($this->normalizeTags($content['tags']));

                $this->request->update([
                    'status' => GeneratorStatus::COMPLETED,
                    'service' => $promptItem->generator->name,
                    'model' => $promptItem->generator->getModel(),
                    'prompt' => $promptItem->prompt,
                    'message' => "{$this->request->type->value} generated successfully.",
                    'response' => $this->encodeResponse($output),
                    'total_tokens' => $output->usage->completionTokens + $output->usage->promptTokens,
                ]);
            });

            ContentGeneratedEvent::dispatch($this->request->id);
        } catch (Throwable $e) {
            $data = [
                'status' => GeneratorStatus::FAILED,
                'response' => ['error' => (array) $e],
            ];

            if ($output instanceof Response) {
                $response = $this->encodeResponse($output);
                $response['error'] = (array) $e;

                $data['message'] = "Error generating request: {$e->getMessage()}";
                $data['response'] = $response;
                $data['service'] = $promptItem instanceof PromptItem
                    ? $promptItem->generator->name
                    : 'unknown';
                $data['model'] = $promptItem instanceof PromptItem
                    ? $promptItem->generator->getModel()
                    : 'unknown';
                $data['total_tokens'] = $output->usage->completionTokens + $output->usage->promptTokens;
            }

            $this->request->update($data);

            ContentGeneratedEvent::dispatch($this->request->id);
            Log::error("Error generating request id: $requestId: {$e->getMessage()}");
            Log::debug($e->getTraceAsString());
        }
    }

    /**
     * @throws Exception
     */
    private function encodeResponse(?Response $response): array
    {
        if (! $response instanceof Response) {
            return [];
        }

        $responseData = [
            'responseMessages' => $response->responseMessages->toArray(),
            'text' => $response->text,
            'finishReason' => $response->finishReason->name,
            'toolCalls' => $response->toolCalls,
            'toolResults' => $response->toolResults,
            'usage' => (array) $response->usage,
            'meta' => (array) $response->meta,
        ];

        return [
            'ai_response' => json_encode($responseData, JSON_THROW_ON_ERROR)
        ];
    }

    private function normalizeTags(array $tags): array
    {
        $tags[] = 'AI Generated';

        return collect($tags)->map(function (string $tag) {
            return str($tag)
                ->trim()
                ->title()
                ->value();
        })
            ->toArray();
    }
}
