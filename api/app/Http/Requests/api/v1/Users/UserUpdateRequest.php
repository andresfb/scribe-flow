<?php

namespace App\Http\Requests\api\v1\Users;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
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
                'unique:users,email'
            ],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'is_default' => ['nullable', 'boolean'],
            'timezone' => ['nullable', 'string'],
        ];
    }
}
