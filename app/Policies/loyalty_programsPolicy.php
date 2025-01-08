<?php

namespace App\Policies;

use App\Models\User;
use App\Models\loyalty_programs;
use Illuminate\Auth\Access\HandlesAuthorization;

class loyalty_programsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_loyalty::program');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('view_loyalty::program');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_loyalty::program');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('update_loyalty::program');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('delete_loyalty::program');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_loyalty::program');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('force_delete_loyalty::program');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_loyalty::program');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('restore_loyalty::program');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_loyalty::program');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, loyalty_programs $loyaltyPrograms): bool
    {
        return $user->can('replicate_loyalty::program');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_loyalty::program');
    }
}
