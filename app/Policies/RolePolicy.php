<?php

namespace App\Policies;

use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_role');
    }

    /**
     * Determine whether the administrator can view the model.
     */
    public function view(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('view_role');
    }

    /**
     * Determine whether the administrator can create models.
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_role');
    }

    /**
     * Determine whether the administrator can update the model.
     */
    public function update(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('update_role');
    }

    /**
     * Determine whether the administrator can delete the model.
     */
    public function delete(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('delete_role');
    }

    /**
     * Determine whether the administrator can bulk delete.
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_role');
    }

    /**
     * Determine whether the administrator can permanently delete.
     */
    public function forceDelete(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the administrator can restore.
     */
    public function restore(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ Restore }}');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the administrator can replicate.
     */
    public function replicate(Administrator $administrator, Role $role): bool
    {
        return $administrator->can('{{ Replicate }}');
    }

    /**
     * Determine whether the administrator can reorder.
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('{{ Reorder }}');
    }
}
