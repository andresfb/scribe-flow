<?php

declare(strict_types=1);

namespace App\Http\Resources\api\v1\Pieces;

use App\Http\Resources\api\v1\Tags\TagResource;
use App\Http\Resources\api\v1\Users\UserResource;
use App\Models\Pieces\Piece;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Piece */
final class PieceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'piece',
            'id' => $this->slug,
            'attributes' => [
                'user_id' => $this->user_id,
                'piece_type_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_type_id ?? 0
                ),
                'piece_status_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_status_id ?? 0
                ),
                'pov_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->pov_id ?? 0
                ),
                'tense_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->tense_id ?? 0
                ),
                'genre_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->genre_id ?? 0
                ),
                'sub_genre_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->sub_genre_id ?? 0
                ),
                'tone_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->tone_id ?? 0
                ),
                'theme_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->theme_id ?? 0
                ),
                'character_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->character_id ?? 0
                ),
                'pace_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->pace_id ?? 0
                ),
                'settings_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->setting_id ?? 0
                ),
                'timeline_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->timeline_id ?? 0
                ),
                'storyline_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->storyline_id ?? 0
                ),
                'style_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->style_id ?? 0
                ),
                'idea' => $this->when(
                    $request->routeIs('pieces.show', 'pieces.create'),
                    $this->idea ?? ''
                ),
                'title' => $this->title ?? '',
                'type' => $this->type->name ?? '',
                'status' => $this->status->name ?? '',
                'pov' => $this->pov->name ?? '',
                'pov_description' => $this->pov->description ?? '',
                'tense' => $this->tense->name ?? '',
                'tense_description' => $this->tense->description ?? '',
                'genre' => $this->genre->name ?? '',
                'genre_description' => $this->genre->description ?? '',
                'sub_genre' => $this->subGenre->name ?? '',
                'sub_genre_description' => $this->subGenre->description ?? '',
                'tone' => $this->tone->name ?? '',
                'tone_description' => $this->tone->description ?? '',
                'theme' => $this->theme->name ?? '',
                'theme_description' => $this->theme->description ?? '',
                'character' => $this->character->name ?? '',
                'character_description' => $this->character->description ?? '',
                'pace' => $this->pace->name ?? '',
                'pace_description' => $this->pace->description ?? '',
                'setting' => $this->setting->name ?? '',
                'setting_description' => $this->setting->description ?? '',
                'timeline' => $this->timeline->name ?? '',
                'storyline' => $this->storyline->name ?? '',
                'storyline_description' => $this->storyline->description ?? '',
                'style' => $this->style->name ?? '',
                'style_description' => $this->style->description ?? '',
                'target_word_count' => $this->target_word_count ?? 0,
                'current_word_count' => $this->current_word_count ?? 0,
                'start_date' => $this->start_date?->toDateString() ?? '',
                'target_completion_date' => $this->target_completion_date?->toDateString() ?? '',
                'completion_date' => $this->completion_date?->toDateString() ?? '',
                'created_at' => $this->created_at->toDatetimeString() ?? '',
                'updated_at' => $this->updated_at->toDatetimeString() ?? '',
                'themes' => $this->whenNull(
                    $request->routeIs('pieces.show', 'pieces.create'),
                    $this->themes ?? []
                ),
                'tags' => $this->whenLoaded(
                    'tags',
                    TagResource::collection($this->tags),
                    []
                ),
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'links' => [
                        'self' => route('user.show', ['user' => $this->user_id]),
                    ],
                ],
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'links' => [
                'self' => $this->when(
                    ! $request->routeIs('pieces.create'),
                    route('pieces.show', ['piece' => $this->slug])
                ),
            ],
        ];
    }
}
