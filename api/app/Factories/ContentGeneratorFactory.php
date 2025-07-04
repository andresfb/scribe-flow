<?php

namespace App\Factories;

use App\Dtos\Ai\GeneratorItem;
use App\Dtos\Ai\PromptItem;
use App\Interfaces\ServiceCheckerInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final readonly class ContentGeneratorFactory
{
    public function execute(PromptItem $promptItem): PromptItem
    {
        /** @var GeneratorItem $item */
        $item = null;

        Log::notice('Searching for AI generator...');

        foreach ($this->loadGenerators()->shuffle() as $generatorItem) {
            if (! $generatorItem->enabled) {
                continue;
            }

            if (! $this->isServiceAvailable($generatorItem)) {
                continue;
            }

            $item = $generatorItem;
            break;
        }

        if ($item === null) {
            throw new RuntimeException('No generators are enabled');
        }

        Log::notice("Found generator: {$item->provider}, using model: {$item->getModel()}");

        return $promptItem->withGenerator($item);
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
