<?php

namespace App\Http\Requests\api\v1\Pieces;

use App\Traits\FailedValidator;
use Illuminate\Foundation\Http\FormRequest;

abstract class BasePieceRequest extends FormRequest
{
    use FailedValidator;

    public function rules(): array
    {
        return  [
            'piece_status_id' => ['nullable', 'integer', 'exists:piece_statuses,id'],
            'piece_type_id' => ['nullable', 'integer', 'exists:piece_types,id'],
            'pov_id' => ['nullable', 'integer', 'exists:povs,id'],
            'tense_id' => ['nullable', 'integer', 'exists:tenses,id'],
            'genre_id' => ['nullable', 'integer', 'exists:genres,id'],
            'sub_genre_id' => ['nullable', 'integer', 'exists:genres,id'],
            'tone_id' => ['nullable', 'integer', 'exists:tones,id'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
            'pace_id' => ['nullable', 'integer', 'exists:paces,id'],
            'setting_id' => ['nullable', 'integer', 'exists:settings,id'],
            'timeline_id' => ['nullable', 'integer', 'exists:timelines,id'],
            'storyline_id' => ['nullable', 'integer', 'exists:storylines,id'],
            'style_id' => ['nullable', 'integer', 'exists:styles,id'],
            'title' => ['nullable', 'min:3', 'max:150'],
            'idea' => ['nullable', 'string'],
            'target_word_count' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'target_completion_date' => ['nullable', 'date'],
            'current_word_count' => ['nullable', 'integer'],
            'completion_date' => ['nullable', 'date'],
            'tags.*' => ['nullable', 'string'],
        ];
    }
}
