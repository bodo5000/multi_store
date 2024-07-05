<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{

    public function before(User|Admin $user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|Admin $user): bool
    {
        return $user->hasAbility('products.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|Admin $user, Product $product): bool
    {
        return $user->hasAbility('products.view') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|Admin $user): bool
    {
        return $user->hasAbility('products.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|Admin $user, Product $product): bool
    {
        return $user->hasAbility('products.update') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Admin $user, Product $product): bool
    {
        return $user->hasAbility('products.delete') && $product->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User|Admin $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|Admin $user, Product $product): bool
    {
        return false;
    }
}
