<?php

namespace App\Http\Requests\Pieces;

class PieceCreateRequest extends BasePieceRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['piece_type_id'] = ['required', 'integer', 'exists:piece_types,id'];
        $rules['title'] = ['required', 'min:3', 'max:150'];

        return $rules;
    }
}
