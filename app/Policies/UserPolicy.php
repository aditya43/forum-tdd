<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the given profile.
     *
     * @param  \App\User $user
     * @param  \App\User $signedInUser
     * @return mixed
     */
    public function update(User $signedInUser, User $user)
    {
        return $signedInUser->id === $user->id;
    }
}
