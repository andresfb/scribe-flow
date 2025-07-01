<?php

namespace App\Policies;

use App\Models\Pieces\Piece;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PiecePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Piece $piece): bool
    {
        return $user->is($piece->user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Piece $piece): bool
    {
        return $user->is($piece->user);
    }

    public function delete(User $user, Piece $piece): bool
    {
        return $user->is($piece->user);
    }

    public function restore(User $user, Piece $piece): bool
    {
        return false;
    }

    public function forceDelete(User $user, Piece $piece): bool
    {
        return false;
    }
}
