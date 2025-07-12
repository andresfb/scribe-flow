<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Listings;

use App\Actions\Listings\PovListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class PovController extends Controller
{
    use ApiResponses;

    public function __invoke(PovListAction $action): JsonResponse
    {
        return $this->ok(
            'List POVs',
            $action->handle()
        );
    }
}
