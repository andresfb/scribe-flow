<?php

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\PacesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class PaceController extends Controller
{
    use ApiResponses;

    public function __invoke(PacesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Paces',
            $action->handle()
        );
    }
}
