<?php

namespace App\Http\Requests\api\v1\Pieces;

use App\Traits\FailedValidator;
use Illuminate\Foundation\Http\FormRequest;

class PieceRequest extends FormRequest
{
    use FailedValidator;

    public function rules(): array
    {
        $rules = [
            'piece_genre_id' => ['nullable', 'integer', 'exists:piece_genres,id'],
            'piece_sub_genre_id' => ['nullable', 'integer', 'exists:piece_genres,id'],
            'piece_tone_id' => ['nullable', 'integer', 'exists:piece_tones,id'],
            'piece_theme_id' => ['nullable', 'integer', 'exists:piece_themes,id'],
            'setting_time_period' => ['nullable', 'string', 'min:2', 'max:255'],
            'setting_location' => ['nullable', 'string', 'min:2', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'target_word_count' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'target_completion_date' => ['nullable', 'date'],
            'completion_date' => ['nullable', 'date'],
            'tags.*' => ['nullable', 'string'],
        ];

        $required = $this->routeIs('pieces.create') ? 'required' : 'nullable';

        $rules['current_word_count'] = [$required, 'integer'];
        $rules['piece_status_id'] = [$required, 'integer', 'exists:piece_statuses,id'];
        $rules['piece_pov_id'] = [$required, 'integer', 'exists:piece_povs,id'];
        $rules['piece_tense_id'] = [$required, 'integer', 'exists:piece_tenses,id'];
        $rules['title'] = [$required, 'min:3', 'max:150'];

        if ($this->routeIs('pieces.generate')) {
            $rules['piece_type_id'] = ['required', 'integer', 'exists:piece_types,id'];
        } else {
            $rules['piece_type_id'] = [$required, 'integer', 'exists:piece_types,id'];
        }

        return $rules;
    }
}
