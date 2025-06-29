<?php

namespace App\Actions\Fortify;

use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse as FortifyPasswordUpdateResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class PasswordUpdateResponse implements FortifyPasswordUpdateResponse
{
    use ApiResponses;

    /**
     * @inheritDoc
     */
    public function toResponse($request): JsonResponse|Response|RedirectResponse
    {
        if (!$request->wantsJson()) {
            return back()->with('status', Fortify::PASSWORD_UPDATED);
        }

        return $this->ok('Password updated successfully');
    }
}
