<?php

namespace App\Http\Requests\Pieces;

class PieceGenerateFullRequest extends BasePieceRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['piece_type_id'] = ['required', 'integer', 'exists:piece_types,id'];

        return $rules;
    }
}
