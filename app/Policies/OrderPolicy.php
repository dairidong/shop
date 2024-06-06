<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_order');
    }

    /**
     * Determine whether the administrator can view the model.
     */
    public function view(Administrator|User $user, Order $order): bool
    {
        if ($user instanceof Administrator) {
            return $user->can('view_order');
        }

        return $order->user_id === $user->id;
    }

    // /**
    //  * Determine whether the administrator can create models.
    //  */
    // public function create(Administrator $administrator): bool
    // {
    //     return $administrator->can('create_order');
    // }

    /**
     * Determine whether the administrator can update the model.
     */
    public function update(Administrator $administrator, Order $order): bool
    {
        return $administrator->can('update_order');
    }

    /**
     * Determine whether the administrator can delete the model.
     */
    public function delete(Administrator|User $user, Order $order): bool
    {
        if ($user instanceof Administrator) {
            return $user->can('delete_order');
        }

        return $order->user_id === $user->id;
    }

    /**
     * Determine whether the administrator can bulk delete.
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_order');
    }

    /**
     * Determine whether the administrator can permanently delete.
     */
    public function forceDelete(Administrator $administrator, Order $order): bool
    {
        return $administrator->can('force_delete_order');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_order');
    }

    /**
     * Determine whether the administrator can restore.
     */
    public function restore(Administrator $administrator, Order $order): bool
    {
        return $administrator->can('restore_order');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_order');
    }

    /**
     * Determine whether the administrator can replicate.
     */
    public function replicate(Administrator $administrator, Order $order): bool
    {
        return $administrator->can('replicate_order');
    }

    public function own(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    public function review(User $user, Order $order): bool
    {
        return $this->own($user, $order) && $order->isFinish() && ! $order->reviewed;
    }
}
