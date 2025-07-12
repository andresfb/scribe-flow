<?php

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\CharactersAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class CharacterController extends Controller
{
    use ApiResponses;

    public function __invoke(CharactersAction $action): JsonResponse
    {
        return $this->ok(
            'List Characters',
            $action->handle()
        );
    }
}
