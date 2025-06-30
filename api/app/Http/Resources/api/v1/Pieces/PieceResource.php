<?php

namespace App\Http\Resources\api\v1\Pieces;

use App\Http\Resources\api\v1\Users\UserResource;
use App\Models\Piece;
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
                'synopsis' => $this->when(
                    $request->routeIs('pieces.show'),
                    $this->synopsis ?? ''
                ),
                'target_word_count' => $this->target_word_count ?? 0,
                'current_word_count' => $this->current_word_count,
                'start_date' => $this->start_date->toDateString() ?? '',
                'target_completion_date' => $this->target_completion_date->toDateString() ?? '',
                'completion_date' => $this->completion_date->toDateString() ?? '',
                'created_at' => $this->created_at->toDateString(),
                'updated_at' => $this->updated_at->toDateString(),
            ],
            'relationships' => [
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
                'type' => [
                    'data' => [
                        'type' => 'piece_type',
                        'id' => $this->piece_type_id,
                    ],
                    'links' => [
                        // TODO: add the piece_type show route
//                        'self' => route('piece-type.show', ['type' => $this->piece_type_id]),
                    ]
                ],
                'status' => [
                    'data' => [
                        'type' => 'piece_status',
                        'id' => $this->piece_status_id,
                    ],
                    'links' => [
                        // TODO: add the piece_status show route
//                        'self' => route('piece-status.show', ['status' => $this->piece_status_id]),
                    ],
                ],
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'links' => [
                'self' => route('pieces.show', ['piece' => $this->id]),
            ],
        ];
    }
}
