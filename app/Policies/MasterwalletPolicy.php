<?php

namespace App\Policies;

use App\User;
use App\Masterwallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterwalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the masterwallet.
     *
     * @param  \App\User  $user
     * @param  \App\Masterwallet  $masterwallet
     * @return mixed
     */
    public function view(User $user, Masterwallet $masterwallet)
    {
        //
    }

    /**
     * Determine whether the user can create masterwallets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the masterwallet.
     *
     * @param  \App\User  $user
     * @param  \App\Masterwallet  $masterwallet
     * @return mixed
     */
    public function update(User $user, Masterwallet $masterwallet)
    {
        return $user->id === $masterwallet->user_id;
    }

    /**
     * Determine whether the user can delete the masterwallet.
     *
     * @param  \App\User  $user
     * @param  \App\Masterwallet  $masterwallet
     * @return mixed
     */
    public function delete(User $user, Masterwallet $masterwallet)
    {
        //
    }
}
