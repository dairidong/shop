<?php

namespace App\Policies;

use App\Models\Administrator;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
        return $administrator->can('view_any_role');
    }

    /**
     * Determine whether the administrator can view the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function view(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('view_role');
    }

    /**
     * Determine whether the administrator can create models.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_role');
    }

    /**
     * Determine whether the administrator can update the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function update(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('update_role');
    }

    /**
     * Determine whether the administrator can delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function delete(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('delete_role');
    }

    /**
     * Determine whether the administrator can bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_role');
    }

    /**
     * Determine whether the administrator can permanently delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function forceDelete(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the administrator can restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function restore(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ Restore }}');
    }

    /**
     * Determine whether the administrator can bulk restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the administrator can replicate.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
    public function replicate(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ Replicate }}');
    }

    /**
     * Determine whether the administrator can reorder.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('{{ Reorder }}');
    }

}
