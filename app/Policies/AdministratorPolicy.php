<?php

namespace App\Policies;

use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdministratorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_administrator');
    }

    /**
     * Determine whether the administrator can view the model.
     */
    public function view(Administrator $administrator): bool
    {
        return $administrator->can('view_administrator');
    }

    /**
     * Determine whether the administrator can create models.
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_administrator');
    }

    /**
     * Determine whether the administrator can update the model.
     */
    public function update(Administrator $administrator): bool
    {
        return $administrator->can('update_administrator');
    }

    /**
     * Determine whether the administrator can delete the model.
     */
    public function delete(Administrator $administrator): bool
    {
        return $administrator->can('delete_administrator');
    }

    /**
     * Determine whether the administrator can bulk delete.
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_administrator');
    }

    /**
     * Determine whether the administrator can permanently delete.
     */
    public function forceDelete(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_administrator');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_administrator');
    }

    /**
     * Determine whether the administrator can restore.
     */
    public function restore(Administrator $administrator): bool
    {
        return $administrator->can('restore_administrator');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_administrator');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function replicate(Administrator $administrator): bool
    {
        return $administrator->can('replicate_administrator');
    }

    /**
     * Determine whether the administrator can reorder.
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_administrator');
    }
}
