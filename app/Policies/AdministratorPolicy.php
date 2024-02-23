<?php

namespace App\Policies;

use App\Models\Administrator;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdministratorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_administrator');
    }

    /**
     * Determine whether the administrator can view the model.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function view(Administrator $administrator): bool
    {
        return $administrator->can('view_administrator');
    }

    /**
     * Determine whether the administrator can create models.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_administrator');
    }

    /**
     * Determine whether the administrator can update the model.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function update(Administrator $administrator): bool
    {
        return $administrator->can('update_administrator');
    }

    /**
     * Determine whether the administrator can delete the model.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function delete(Administrator $administrator, Administrator $to_delete): bool
    {
        return $administrator->can('delete_administrator') && $to_delete->id !== $administrator->id;
    }

    /**
     * Determine whether the administrator can bulk delete.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_administrator');
    }

    /**
     * Determine whether the administrator can permanently delete.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function forceDelete(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_administrator');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_administrator');
    }

    /**
     * Determine whether the administrator can restore.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function restore(Administrator $administrator): bool
    {
        return $administrator->can('restore_administrator');
    }

    /**
     * Determine whether the administrator can bulk restore.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_administrator');
    }

    /**
     * Determine whether the administrator can bulk restore.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function replicate(Administrator $administrator): bool
    {
        return $administrator->can('replicate_administrator');
    }

    /**
     * Determine whether the administrator can reorder.
     *
     * @param \App\Models\Administrator $administrator
     * @return bool
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_administrator');
    }
}
