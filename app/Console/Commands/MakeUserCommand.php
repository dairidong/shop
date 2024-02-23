<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class MakeUserCommand extends FilamentMakeUserCommand
{
    protected $signature = 'make:filament-user
                            {--username= : A valid and unique email username}
                            {--name= : The name of the user}
                            {--password= : The password for the user (min. 8 characters)}';

    /**
     * @var array{'name': string | null, 'username': string | null, 'password': string | null}
     */
    protected array $options;

    /**
     * @return array{'name': string, 'username': string, 'password': string}
     */
    protected function getUserData(): array
    {
        return [
            'username' => $this->options['email'] ?? text(
                    label: 'Username',
                    required: true,
                    validate: fn(string $username): ?string => match (true) {
                        Str::isAscii($username),
                        static::getUserModel()::where('username', $username)->exists() => 'A user with this email address already exists',
                        default => null,
                    },
                ),

            'name' => $this->options['name'] ?? text(
                    label: 'Name',
                    required: true,
                ),

            'password' => Hash::make($this->options['password'] ?? password(
                label: 'Password',
                required: true,
            )),
        ];
    }
}
