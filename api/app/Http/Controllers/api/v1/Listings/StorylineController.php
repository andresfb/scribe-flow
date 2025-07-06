<?php

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\StorylinesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class StorylineController extends Controller
{
    use ApiResponses;

    public function __invoke(StorylinesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Storylines',
            $action->handle()
        );
    }
}
