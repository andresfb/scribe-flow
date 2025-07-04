<?php

declare(strict_types=1);

namespace App\Http\Requests\api\v1\Pieces;

use Illuminate\Foundation\Http\FormRequest;

final class PieceListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'include' => ['nullable', 'string'],
            'sort' => ['nullable', 'string'],
            'filter' => ['nullable', 'array'],
        ];
    }
}
