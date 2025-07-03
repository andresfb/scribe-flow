<?php

namespace App\Factories;

use App\Dtos\Ai\GeneratorItem;
use App\Dtos\Ai\PromptItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use RuntimeException;

final readonly class ContentGeneratorFactory
{
    public function execute(PromptItem $promptItem): PromptItem
    {
        $item = $this->loadGenerators()
            ->shuffle()
            ->each(function (GeneratorItem $item): ?GeneratorItem {
                if ($item->enabled) {
                    return $item;
                }

                return null;
            }
        );

        if ($item === null) {
            throw new RuntimeException('No generators are enabled');
        }

        return $promptItem->withGenerator($item);
    }

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
}
