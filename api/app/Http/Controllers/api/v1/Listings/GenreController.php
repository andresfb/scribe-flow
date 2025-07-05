<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\GenresListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class GenreController extends Controller
{
    use ApiResponses;

    public function __invoke(GenresListAction $action): JsonResponse
    {
        return $this->ok(
            'List Genres',
            $action->handle()
        );
    }
}
