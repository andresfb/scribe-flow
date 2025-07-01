<?php

namespace App\Http\Resources\api\v1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'timezone' => $this->timezone,
                'email_verified_at' => $this->email_verified_at->toDatetimeString() ?? '',
                'created_at' => $this->created_at->toDatetimeString(),
                'updated_at' => $this->updated_at->toDatetimeString(),
                $this->mergeWhen($this->whenLoaded('tokens'), [
                    'tokens_count' => $this->tokens->count(),
                ]),
                $this->mergeWhen($this->whenLoaded('notifications'), [
                    'notifications_count' => $this->notifications->count(),
                    'read_notifications_count' => $this->readNotifications->count(),
                    'unread_notifications_count' => $this->unreadNotifications->count(),
                ]),
            ],
            'links' => [
                'self' => route('user.show', ['user' => $this->id]),
            ],
        ];
    }
}
