<?php

namespace App\Http\Controllers\api\v1\Listings;

use App\Actions\Listings\SettingsListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    use ApiResponses;

    public function __invoke(SettingsListAction $action): JsonResponse
    {
        return $this->ok(
            'List Settings',
            $action->handle()
        );
    }
}
