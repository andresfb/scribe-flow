<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\TonesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class ToneController extends Controller
{
    use ApiResponses;

    public function __invoke(TonesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Tones',
            $action->handle()
        );
    }
}
