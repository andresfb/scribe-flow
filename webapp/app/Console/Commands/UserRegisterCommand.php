<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Throwable;

use function Laravel\Prompts\clear;
use function Laravel\Prompts\error;
use function Laravel\Prompts\form;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;

final class UserRegisterCommand extends Command
{
    protected $signature = 'user:register';

    protected $description = 'Register a new user.';

    public function handle(): void
    {
        try {
            clear();
            intro('Register a new user');

            $responses = form()
                ->text(
                    label: 'Full Name:',
                    placeholder: 'John Doe',
                    required: true,
                    validate: 'string|max:255',
                    name: 'name',
                )
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
                ->password(
                    label: 'Confirm Password:',
                    required: true,
                    name: 'confirm_password',
                )
                ->confirm(
                    label: 'Default User?',
                    name: 'is_default',
                )
                ->submit();

            if (User::where('email', $responses['email'])->exists()) {
                throw new RuntimeException('Email already exists.');
            }

            if ($responses['password'] !== $responses['confirm_password']) {
                throw new RuntimeException('Passwords do not match.');
            }

            if ($responses['is_default']) {
                $defaultUser = User::getDefaultUser();

                if ($defaultUser instanceof User) {
                    throw new RuntimeException('A default user already exists.');
                }
            }

            DB::transaction(static function () use ($responses): void {
                $user = User::create([
                    'name' => $responses['name'],
                    'email' => $responses['email'],
                    'password' => Hash::make($responses['password']),
                    'email_verified_at' => now(),
                    'is_default' => $responses['is_default'],
                ]);

                if ($user === null) {
                    throw new RuntimeException('User could not be created.');
                }

                event(new Registered($user));
            });

            outro('User registered successfully.');
        } catch (Throwable $throwable) {
            error("\nSomething went wrong:\n".$throwable->getMessage());
        } finally {
            $this->line('');
        }
    }
}
