<?php

namespace App\Policies;

use App\User;
use App\Models\Shop;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the store.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function view(User $user, Shop $shop)
    {
        //
    }

    /**
     * Determine whether the user can create shops.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the store.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Shop  $store
     * @return mixed
     */
    public function update(User $user, Shop $shop)
    {
        return $user->id === $shop->user_id;
    }

    /**
     * Determine whether the user can delete the store.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Shop  $shop
     * @return mixed
     */
    public function delete(User $user, Shop $shop)
    {
        return $user->id === $shop->user_id;
    }
}
