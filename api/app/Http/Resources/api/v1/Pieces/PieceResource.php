<?php

namespace App\Http\Resources\api\v1\Pieces;

use App\Http\Resources\api\v1\Tags\TagResource;
use App\Http\Resources\api\v1\Users\UserResource;
use App\Models\Pieces\Piece;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Piece */
class PieceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'piece',
            'id' => $this->id,
            'attributes' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'type' => $this->pieceType->name,
                'status' => $this->pieceStatus->name,
                'pov' => $this->piecePov->name,
                'tense' => $this->pieceTense->name,
                'genre' => $this->genre ?? '',
                'sub_genre' => $this->sub_genre ?? '',
                'setting_time_period' =>  $this->when(
                    $request->routeIs('pieces.show'),
                    $this->setting_time_period ?? '',
                ),
                'setting_location' =>  $this->when(
                    $request->routeIs('pieces.show'),
                    $this->setting_location ?? '',
                ),
                'synopsis' => $this->when(
                    $request->routeIs('pieces.show'),
                    $this->synopsis ?? ''
                ),
                'target_word_count' => $this->target_word_count ?? 0,
                'current_word_count' => $this->current_word_count,
                'start_date' => $this->start_date->toDateString() ?? '',
                'target_completion_date' => $this->target_completion_date->toDateString() ?? '',
                'completion_date' => $this->completion_date->toDateString() ?? '',
                'themes' => $this->when(
                    $request->routeIs('pieces.show'),
                    $this->themes
                ),
                'tags' => TagResource::collection($this->whenLoaded('tags')),
                'created_at' => $this->created_at->toDatetimeString(),
                'updated_at' => $this->updated_at->toDatetimeString(),
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
                'self' => route('pieces.show', ['piece' => $this->slug]),
            ],
        ];
    }
}
