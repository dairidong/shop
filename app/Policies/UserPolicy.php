<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_user');
    }

    /**
     * Determine whether the administrator can view the model.
     */
    public function view(Administrator $administrator, User $user): bool
    {
        return $administrator->can('view_user');
    }

    /**
     * Determine whether the administrator can create models.
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_user');
    }

    /**
     * Determine whether the administrator can update the model.
     */
    public function update(Administrator $administrator, User $user): bool
    {
        return $administrator->can('update_user');
    }

    /**
     * Determine whether the administrator can delete the model.
     */
    public function delete(Administrator|User $delete_by, User $user): bool
    {
        if ($delete_by instanceof Administrator) {
            return $delete_by->can('delete_user');
        }

        return $delete_by->is($user);
    }

    /**
     * Determine whether the administrator can bulk delete.
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_user');
    }

    /**
     * Determine whether the administrator can permanently delete.
     */
    public function forceDelete(Administrator $administrator, User $user): bool
    {
        return $administrator->can('force_delete_user');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_user');
    }

    /**
     * Determine whether the administrator can restore.
     */
    public function restore(Administrator $administrator, User $user): bool
    {
        return $administrator->can('restore_user');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_user');
    }

    /**
     * Determine whether the administrator can replicate.
     */
    public function replicate(Administrator $administrator, User $user): bool
    {
        return $administrator->can('replicate_user');
    }

    /**
     * Determine whether the administrator can reorder.
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_user');
    }
}
