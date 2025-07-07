<?php

namespace App\Commands;

use App\Dtos\UserItem;
use App\Services\AuthService;
use App\Services\LoginService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use RuntimeException;
use Throwable;

use function Laravel\Prompts\clear;
use function Laravel\Prompts\error;
use function Laravel\Prompts\form;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\pause;

// TODO: When the user needs to type the stories, we need to open iA Writer with the actual file to edit.
// TODO: We then need to trigger a file watcher that check if the file was saved and uploads the text to the API's versioning for storage.

class MenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Main Menu';

    protected bool $loginIn = false;

    public function __construct(
        private readonly AuthService $authService,
        private readonly LoginService $loginService
    ) {
        parent::__construct();
        $this->loginService->setToScreen(true);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        clear();

        try {
            while (true) {
                intro('Scribe Menu');

                $user = $this->authService->getUserInfo();
                if ($user === null) {
                    $this->login();

                    continue;
                }

                if ($this->loginIn) {
                    $this->loginIn = false;
                    info('Logged in as ' . $user->name);
                }

                // TODO: check how this menu works here: https://github.com/php-school/cli-menu
                $option = $this->menu('Pizza menu', [
                    'Freshly baked muffins',
                    'Freshly baked croissants',
                    'Turnovers, crumb cake, cinnamon buns, scones',
                ])
                    ->open();

                if ($option === null) {
                    outro('Goodbye!');

                    return;
                }

                $this->info("You have chosen the option number #$option");
                pause('Press any key to continue...');
            }
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

    private function login(): void
    {
        clear();
        intro('Scribe Menu');

        $this->loginIn = true;
        $message = 'Please login to continue';
        $tries = 3;

        while ($tries > 0) {
            $result = form()
                ->info($message)
                ->text(
                    label: 'Email:',
                    placeholder: 'user@example.com',
                    required: true,
                    validate: 'string|lowercase|email|max:255',
                    name: 'email',
                )
                ->password(
                    label: 'Password:',
                    required: true,
                    validate: ['password' => 'min:8'],
                    hint: 'Minimum 8 characters.',
                    name: 'password',
                )
                ->submit();

            try {
                $result = $this->loginService->login(
                    $result['email'],
                    $result['password'],
                );

                $item = UserItem::from($result);
                $this->authService->setUser($item);

                return;
            } catch (Throwable $e) {
                $message = 'Login failed, please try again';
                error('Login failed: ' . $e->getMessage());
                $tries--;

                continue;
            }
        }

        throw new RuntimeException('Login failed');
    }
}
