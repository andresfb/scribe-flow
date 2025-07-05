<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

trait FailedValidator
{
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            $validator,
            response()->json([
                'message' => $validator->errors()->first(),
                'status' => false,
                'data' => $validator->errors(),
            ], 422)
        );
    }
}
