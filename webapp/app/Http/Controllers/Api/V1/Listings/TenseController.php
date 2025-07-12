<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\TenseListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class TenseController extends Controller
{
    use ApiResponses;

    public function __invoke(TenseListAction $action): JsonResponse
    {
        return $this->ok(
            'List Tenses',
            $action->handle()
        );
    }
}
