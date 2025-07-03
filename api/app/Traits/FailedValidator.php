<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

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
