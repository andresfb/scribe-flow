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
            'id' => $this->slug,
            'attributes' => [
                'user_id' => $this->user_id,
                'title' => $this->title ?? '',
                'type' => $this->pieceType?->name ?? '',
                'status' => $this->pieceStatus?->name ?? '',
                'pov' => $this->piecePov?->name ?? '',
                'tense' => $this->pieceTense?->name ?? '',
                'piece_type_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_type_id ?? 0
                ),
                'piece_status_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_status_id ?? 0
                ),
                'piece_pov_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_pov_id ?? 0
                ),
                'piece_tense_id' => $this->when(
                    $request->routeIs('pieces.create'),
                    $this->piece_tense_id ?? 0
                ),
                'genre' => $this->genre ?? '',
                'sub_genre' => $this->sub_genre ?? '',
                'setting_time_period' =>  $this->when(
                    $request->routeIs('pieces.show', 'pieces.create'),
                    $this->setting_time_period ?? '',
                ),
                'setting_location' =>  $this->when(
                    $request->routeIs('pieces.show', 'pieces.create'),
                    $this->setting_location ?? '',
                ),
                'synopsis' => $this->when(
                    $request->routeIs('pieces.show', 'pieces.create'),
                    $this->synopsis ?? ''
                ),
                'target_word_count' => $this->target_word_count ?? 0,
                'current_word_count' => $this->current_word_count ?? 0,
                'start_date' => $this->start_date?->toDateString() ?? '',
                'target_completion_date' => $this->target_completion_date?->toDateString() ?? '',
                'completion_date' => $this->completion_date?->toDateString() ?? '',
                'created_at' => $this->created_at?->toDatetimeString() ?? '',
                'updated_at' => $this->updated_at?->toDatetimeString() ?? '',
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
