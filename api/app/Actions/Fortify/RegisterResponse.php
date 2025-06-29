<?php

namespace App\Actions\Fortify;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\RegisterResponse as FortifyRegisterResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse extends BaseAccessResponse implements FortifyRegisterResponse
{
    /**
     * @inheritDoc
     */
    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        if (!$request->wantsJson()) {
            return redirect()->intended(Fortify::redirects('register'));
        }

        return $this->accessResponse($request, 'Registration successful');
    }
}
