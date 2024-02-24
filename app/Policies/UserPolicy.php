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
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_user');
    }

    /**
     * Determine whether the administrator can view the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function view(Administrator $administrator, User $user): bool
    {
        return $administrator->can('view_user');
    }

    /**
     * Determine whether the administrator can create models.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_user');
    }

    /**
     * Determine whether the administrator can update the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function update(Administrator $administrator, User $user): bool
    {
        return $administrator->can('update_user');
    }

    /**
     * Determine whether the administrator can delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function delete(Administrator $administrator, User $user): bool
    {
        return $administrator->can('delete_user');
    }

    /**
     * Determine whether the administrator can bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_user');
    }

    /**
     * Determine whether the administrator can permanently delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDelete(Administrator $administrator, User $user): bool
    {
        return $administrator->can('force_delete_user');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_user');
    }

    /**
     * Determine whether the administrator can restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restore(Administrator $administrator, User $user): bool
    {
        return $administrator->can('restore_user');
    }

    /**
     * Determine whether the administrator can bulk restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_user');
    }

    /**
     * Determine whether the administrator can replicate.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function replicate(Administrator $administrator, User $user): bool
    {
        return $administrator->can('replicate_user');
    }

    /**
     * Determine whether the administrator can reorder.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_user');
    }

}
