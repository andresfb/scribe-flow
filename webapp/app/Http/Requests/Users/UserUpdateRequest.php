<?php

declare(strict_types=1);

namespace App\Http\Requests\Users;

use App\Actions\Fortify\PasswordValidationRules;
use App\Traits\FailedValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

final class UserUpdateRequest extends FormRequest
{
    use FailedValidator;
    use PasswordValidationRules;

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'is_default' => ['nullable', 'boolean'],
            'timezone' => ['nullable', 'string'],
        ];
    }
}
