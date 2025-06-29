<?php

namespace App\Actions\Fortify;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as FortifyLoginResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

final class LoginResponse extends BaseAccessResponse implements FortifyLoginResponse
{
    /**
     * @inheritDoc
     */
    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        if (!$request->wantsJson()) {
            return redirect()->intended(Fortify::redirects('login'));
        }

        return $this->accessResponse($request, 'Login successful');
    }
}
