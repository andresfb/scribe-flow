<?php

namespace App\Http\Requests\api\v1\Pieces;

class PieceGenerateFullRequest extends BasePieceRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['piece_type_id'] = ['required', 'integer', 'exists:piece_types,id'];

        return $rules;
    }
}
