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
            'pov_id' => ['nullable', 'integer', 'exists:povs,id'],
            'tense_id' => ['nullable', 'integer', 'exists:tenses,id'],
            'genre_id' => ['nullable', 'integer', 'exists:genres,id'],
            'sub_genre_id' => ['nullable', 'integer', 'exists:genres,id'],
            'tone_id' => ['nullable', 'integer', 'exists:tones,id'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
            'pace_id' => ['nullable', 'integer', 'exists:paces,id'],
            'setting_id' => ['nullable', 'integer', 'exists:settings,id'],
            'setting_time_period' => ['nullable', 'string', 'min:2', 'max:255'],
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
