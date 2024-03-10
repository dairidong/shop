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
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function viewAny(Administrator $administrator): bool
    {
        return $administrator->can('view_any_category');
    }

    /**
     * Determine whether the administrator can view the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function view(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('view_category');
    }

    /**
     * Determine whether the administrator can create models.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create_category');
    }

    /**
     * Determine whether the administrator can update the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function update(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('update_category');
    }

    /**
     * Determine whether the administrator can delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function delete(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('delete_category');
    }

    /**
     * Determine whether the administrator can bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function deleteAny(Administrator $administrator): bool
    {
        return $administrator->can('delete_any_category');
    }

    /**
     * Determine whether the administrator can permanently delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function forceDelete(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('force_delete_category');
    }

    /**
     * Determine whether the administrator can permanently bulk delete.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function forceDeleteAny(Administrator $administrator): bool
    {
        return $administrator->can('force_delete_any_category');
    }

    /**
     * Determine whether the administrator can restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function restore(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('restore_category');
    }

    /**
     * Determine whether the administrator can bulk restore.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function restoreAny(Administrator $administrator): bool
    {
        return $administrator->can('restore_any_category');
    }

    /**
     * Determine whether the administrator can replicate.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Category  $category
     * @return bool
     */
    public function replicate(Administrator $administrator, Category $category): bool
    {
        return $administrator->can('replicate_category');
    }

    /**
     * Determine whether the administrator can reorder.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return bool
     */
    public function reorder(Administrator $administrator): bool
    {
        return $administrator->can('reorder_category');
    }

}
