<?php

use App\Models\GeneratorRequest;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('generator.{requestId}', static function (User $user, int $requestId) {
    return $user->id === GeneratorRequest::findOrNew($requestId)->user_id;
});
