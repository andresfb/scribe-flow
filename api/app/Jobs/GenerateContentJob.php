<?php

namespace App\Jobs;

use App\Services\GeneratorContentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateContentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly int $requestId){}

    /**
     * @throws Throwable
     */
    public function handle(GeneratorContentService $service): void
    {
        try {
            $service->execute($this->requestId);
        } catch (Throwable $e) {
            Log::error("Error generating request id: $this->requestId: {$e->getMessage()}");

            throw $e;
        }
    }
}
