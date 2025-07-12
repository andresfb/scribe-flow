<?php

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\TimelinesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class TimelineController extends Controller
{
    use ApiResponses;

    public function __invoke(TimelinesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Timelines',
            $action->handle()
        );
    }
}
