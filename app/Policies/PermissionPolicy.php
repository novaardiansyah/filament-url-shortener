<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view-any Permission');
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view Permission');
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('create Permission');
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('update Permission');
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('delete Permission');
  }

  /**
   * Determine whether the user can delete any models.
   */
  public function deleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('delete-any Permission');
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('restore Permission');
  }

  /**
   * Determine whether the user can restore any models.
   */
  public function restoreAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('restore-any Permission');
  }

  /**
   * Determine whether the user can replicate the model.
   */
  public function replicate(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('replicate Permission');
  }

  /**
   * Determine whether the user can reorder the models.
   */
  public function reorder(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('reorder Permission');
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Permission $permission): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('force-delete Permission');
  }

  /**
   * Determine whether the user can permanently delete any models.
   */
  public function forceDeleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('force-delete-any Permission');
  }
}