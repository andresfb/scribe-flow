<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Throwable;

use function Laravel\Prompts\clear;

final class TestAppCommand extends Command
{
    protected $signature = 'test:app';

    protected $description = 'Tests runner';

    public function handle(): void
    {
        clear();

        try {
            $this->info("\nStarting at: ".now()."\n");

        } catch (Throwable $e) {
            $this->error("\nError Testing");
            $this->error($e->getMessage().PHP_EOL);
        } finally {
            $this->info("\nDone at: ".now()."\n");
        }
    }
}
