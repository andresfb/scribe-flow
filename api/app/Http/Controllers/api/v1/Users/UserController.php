<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1\Users;

use App\Actions\Users\LoadUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Dtos\Users\UserItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Users\UserUpdateRequest;
use App\Http\Resources\api\v1\Users\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\RelationshipIncluder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

final class UserController extends Controller
{
    use ApiResponses;
    use AuthorizesRequests;
    use RelationshipIncluder;

    public function show(int $user, LoadUserAction $userAction): UserResource
    {
        $includes = [];
        // TODO: add the user includes
        //        if ($this->include('incomeCategories')) {
        //            $includes[] = 'incomeCategories';
        //        }

        $userModel = $userAction->handle(
            $user,
            $includes
        );

        $this->authorize('view', $userModel);

        return new UserResource($userModel);
    }

    public function update(UserUpdateRequest $request, User $user, UpdateUserAction $userAction): UserResource|JsonResponse
    {
        $this->authorize('update', $user);

        try {
            $item = UserItem::from($request);

            if (! $item->isDirty()) {
                return $this->ok('No changes were made');
            }

            $user = $userAction->handle($user->id, $item);

            return new UserResource($user);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return $this->error(
                message: 'Something went wrong',
                data: [
                    'error' => $e->getMessage(),
                ],
                status: 500,
            );
        }

    }
}
