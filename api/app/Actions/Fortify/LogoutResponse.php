<?php

namespace App\Actions\Fortify;

use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LogoutResponse as FortifyLogoutResponse;
use Laravel\Fortify\Fortify;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements FortifyLogoutResponse
{
    use ApiResponses;

    /**
     * @inheritDoc
     */
    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        if (!$request->wantsJson()) {
            return redirect(Fortify::redirects('logout', '/'));
        }

        /** @var PersonalAccessToken $token */
        $token = $request->user()->currentAccessToken();

        $token->delete();

        return $this->ok('Logout successful');
    }
}
