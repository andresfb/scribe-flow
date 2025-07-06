<?php

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\StylesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class StyleController extends Controller
{
    use ApiResponses;

    public function __invoke(StylesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Styles',
            $action->handle()
        );
    }
}
