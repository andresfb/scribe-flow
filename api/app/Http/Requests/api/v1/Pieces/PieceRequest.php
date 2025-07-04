<?php

declare(strict_types=1);

namespace App\Http\Requests\api\v1\Pieces;

use App\Traits\FailedValidator;
use Illuminate\Foundation\Http\FormRequest;

final class PieceRequest extends FormRequest
{
    use FailedValidator;

    public function rules(): array
    {
        $rules = [
            'piece_pov_id' => ['nullable', 'integer', 'exists:piece_povs,id'],
            'piece_tense_id' => ['nullable', 'integer', 'exists:piece_tenses,id'],
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
            'current_word_count' => ['nullable', 'integer'],
            'completion_date' => ['nullable', 'date'],
            'tags.*' => ['nullable', 'string'],
        ];

        $required = $this->routeIs('pieces.create') ? 'required' : 'nullable';

        $rules['title'] = [$required, 'min:3', 'max:150'];
        $rules['piece_status_id'] = [$required, 'integer', 'exists:piece_statuses,id'];

        if ($this->routeIs('pieces.generate')) {
            $rules['piece_type_id'] = ['required', 'integer', 'exists:piece_types,id'];
        } else {
            $rules['piece_type_id'] = [$required, 'integer', 'exists:piece_types,id'];
        }

        return $rules;
    }
}
