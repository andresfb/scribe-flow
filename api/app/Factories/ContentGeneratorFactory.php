<?php

declare(strict_types=1);

namespace App\Factories;

use App\Dtos\Ai\GeneratorItem;
use App\Dtos\Ai\PromptItem;
use App\Interfaces\ServiceCheckerInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class ContentGeneratorFactory
{
    private bool $clearedCache = false;

    private string $cacheTag = 'ai:generators';

    public function execute(PromptItem $promptItem): PromptItem
    {
        $item = null;

        Log::notice('Searching for AI generator...');

        /** @var GeneratorItem $generatorItem */
        foreach ($this->loadGenerators()->shuffle() as $generatorItem) {
            if (! $generatorItem->enabled) {
                continue;
            }

            $cacheKey = $generatorItem->getCacheKey();
            if (cache()->has($cacheKey)) {
                continue;
            }

            if (! $this->isServiceAvailable($generatorItem)) {
                continue;
            }

            $item = $generatorItem;
            cache()->tags($this->cacheTag)
                ->put(
                    $cacheKey,
                    $generatorItem->name,
                    now()->addMinutes(
                        Config::integer('generators.cache_ttl_minutes')
                    )
                );

            break;
        }

        if ($item !== null) {
            Log::notice("Found generator: {$item->name}, using model: {$item->getModel()}");

            return $promptItem->withGenerator($item);
        }

        if (! $this->clearedCache) {
            cache()->tags($this->cacheTag)->flush();
            $this->clearedCache = true;

            return $this->execute($promptItem);
        }

        throw new RuntimeException('No generators are enabled');

    }

    /**
     * @return Collection<GeneratorItem>
     */
    private function loadGenerators(): Collection
    {
        $generators = collect();

        foreach (Config::array('generators.services') as $item) {
            $generators->push(
                GeneratorItem::from($item)
            );
        }

        return $generators;
    }

    private function isServiceAvailable(GeneratorItem $generatorItem): bool
    {
        if (! $generatorItem->check_service) {
            return true;
        }

        if ($generatorItem->service_checker === null) {
            return false;
        }

        $checker = app($generatorItem->service_checker);
        if (! $checker instanceof ServiceCheckerInterface) {
            return false;
        }

        return $checker->isAvailable();
    }
}
