<?php

namespace App\Http\Requests\api\v1\Pieces;

use Illuminate\Foundation\Http\FormRequest;

class PieceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'piece_type_id' => ['required', 'exists:piece_types'],
            'piece_status_id' => ['required', 'exists:piece_statuses'],
            'piece_pov_id' => ['required', 'exists:piece_povs'],
            'user_id' => ['required', 'exists:users'],
            'title' => ['required', 'min:3', 'max:150'],
            'genre' => ['nullable', 'string', 'min:2', 'max:100'],
            'sub_genre' => ['nullable', 'string', 'min:2', 'max:100'],
            'setting_time_period' => ['nullable', 'string', 'min:2', 'max:255'],
            'setting_location' => ['nullable', 'string', 'min:2', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'target_word_count' => ['nullable', 'integer'],
            'current_word_count' => ['required', 'integer'],
            'start_date' => ['nullable', 'date'],
            'target_completion_date' => ['nullable', 'date'],
            'completion_date' => ['nullable', 'date'],
        ];
    }
}
