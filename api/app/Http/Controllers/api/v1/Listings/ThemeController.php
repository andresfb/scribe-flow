<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\ThemesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

final class ThemeController extends Controller
{
    use ApiResponses;

    public function __invoke(ThemesListAction $action): JsonResponse
    {
        return $this->ok(
            'List Tones',
            $action->handle()
        );
    }
}
