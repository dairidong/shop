<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the administrator can view any models.
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_category');
    }

    /**
     * Determine whether the administrator can view the model.
     */
    public function view(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('view_category');
    }

    /**
     * Determine whether the administrator can create models.
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_category');
    }

    /**
     * Determine whether the administrator can update the model.
     */
    public function update(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('update_category');
    }

    /**
     * Determine whether the administrator can delete the model.
     */
    public function delete(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('delete_category');
    }

    /**
     * Determine whether the administrator can bulk delete.
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_category');
    }

    /**
     * Determine whether the administrator can permanently delete.
     */
    public function forceDelete(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('force_delete_category');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_category');
    }

    /**
     * Determine whether the administrator can restore.
     */
    public function restore(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('restore_category');
    }

    /**
     * Determine whether the administrator can bulk restore.
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_category');
    }

    /**
     * Determine whether the administrator can replicate.
     */
    public function replicate(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('replicate_category');
    }

    /**
     * Determine whether the administrator can reorder.
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_category');
    }
}
