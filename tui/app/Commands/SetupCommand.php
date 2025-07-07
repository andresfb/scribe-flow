<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use RuntimeException;
use Throwable;

use function Laravel\Prompts\clear;
use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\warning;
use function Laravel\Prompts\info;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            clear();
            intro('Scribe Setup');

            if (! $this->checkEnvs()) {
                $this->printEnvsError();

                return;
            }

            info('Creating required directories...');

            $homePath = Config::string('constants.home_path');
            $directories = [
                $homePath,
                "$homePath/bin",
                "$homePath/data",
                "$homePath/logs"
            ];

            foreach ($directories as $directory) {
                $this->createDirectory($directory);
            }

            $this->line('');
            info('Creating scribe database/log files...');

            $databasePath = Config::string('database.connections.sqlite.database');
            $this->createFile($databasePath);

            $logPath = Config::string('logging.channels.single.path');
            $this->createFile($logPath);

            $this->line('');
            info('Running migrations...');

            $this->call('migrate:fresh');

            outro('Setup complete!');
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        } finally {
            $this->line('');
        }
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function checkEnvs(): bool
    {
        if (config('constants.home_path') === null) {
            return false;
        }

        if (config('constants.api.url') === null) {
            return false;
        }

        if (config('database.connections.sqlite.database') === null) {
            return false;
        }

        return config('logging.channels.single.path') !== null;
    }

    private function printEnvsError(): void
    {
        error('Environmental variables are not set.');
        warning('Make sure you export the following variables. Update as needed:');

        warning("\texport SCRIBE_HOME=\$HOME/.scribe\n"
              . "\texport SCRIBE_API_URL=\"[API URL]\"\n"
              . "\texport SCRIBE_DB_CONNECTION=\"sqlite\"\n"
              . "\texport SCRIBE_DB_DATABASE=\$SCRIBE_HOME/data/database.sqlite\n"
              . "\texport SCRIBE_LOG_PATH=\$SCRIBE_HOME/logs/scribe.log\n"
              . "\texport PATH=\$PATH:\$SCRIBE_HOME/bin\n"
        );
    }

    private function createDirectory(string $dir): void
    {
        File::ensureDirectoryExists($dir);
        if (! File::exists($dir)) {
            throw new RuntimeException("Failed to create $dir");
        }

        echo '.';
    }

    private function createFile(string $filename): void
    {
        touch($filename);
        if (! File::exists($filename)) {
            throw new RuntimeException("Failed to create $filename");
        }

        if (! chmod($filename, 0755)) {
            throw new RuntimeException("Failed to set permissions on $filename");
        }

        echo '.';
    }
}
