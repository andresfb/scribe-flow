<?php

namespace App\Http\Requests\api\v1\Pieces;

use Illuminate\Foundation\Http\FormRequest;

class PieceListRequest extends FormRequest
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
