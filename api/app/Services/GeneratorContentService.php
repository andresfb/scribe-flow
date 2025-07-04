<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\Ai\PromptItem;
use App\Enums\GeneratorStatus;
use App\Models\GeneratorRequest;
use App\Models\Lists\PieceStatus;
use App\Models\Lists\PieceType;
use App\Models\Pieces\Piece;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Text\Response;
use RuntimeException;
use Throwable;

final readonly class GeneratorContentService
{
    private GeneratorRequest $request;

    public function __construct(
        private PrepareAiRequestService $prepareService,
        private GeneratorAiService $aiService,
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
                ->replace('json', '');

            $content = json_decode($outputText, true, 512, JSON_THROW_ON_ERROR);

            DB::transaction(function () use ($content, $output, $promptItem): void {
                $data = $promptItem->pieceItem->toArray();
                $data['user_id'] = $this->request->user_id;
                $data['piece_status_id'] = PieceStatus::getDefault();
                $data['synopsis'] = $content['content'];
                $data['target_word_count'] = PieceType::getWordCount($promptItem->pieceItem->piece_type_id);

                if (isset($content['title'])) {
                    $data['title'] = $content['title'];
                }

                Piece::create($data);

                $this->request->update([
                    'status' => GeneratorStatus::COMPLETED,
                    'service' => $promptItem->generator->provider,
                    'model' => $promptItem->generator->getModel(),
                    'prompt' => $promptItem->prompt,
                    'response' => $this->encodeResponse($output),
                    'total_tokens' => $output->usage->completionTokens + $output->usage->promptTokens,
                ]);
            });

            // TODO: add the broadcasting processes

            //            broadcast(new ContentGenerated($this->generation))->toOthers();
        } catch (Throwable $e) {
            $data = [
                'status' => GeneratorStatus::FAILED,
                'response' => ['error' => (array) $e],
            ];

            if ($output instanceof Response) {
                $response = $this->encodeResponse($output);
                $response['error'] = (array) $e;

                $data['response'] = $response;
                $data['service'] = $promptItem instanceof PromptItem
                    ? $promptItem->generator->provider
                    : 'unknown';
                $data['model'] = $promptItem instanceof PromptItem
                    ? $promptItem->generator->getModel()
                    : 'unknown';
                $data['total_tokens'] = ($output->usage->completionTokens + $output->usage->promptTokens) ?? 0;
            }

            $this->request->update($data);

            //            broadcast(new ContentFailed($this->generation))->toOthers();

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

        $aiResponse = json_encode($responseData, JSON_THROW_ON_ERROR);

        Log::info(
            "AI Generated this response: $aiResponse from this request: "
            .print_r($this->request->toArray(), true)
        );

        return ['ai_response' => $aiResponse];
    }
}
