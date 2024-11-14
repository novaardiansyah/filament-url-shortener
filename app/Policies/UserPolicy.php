<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;

use App\Models\User;

class UserPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view-any User');
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view User');
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('create User');
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('update User');
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('delete User');
  }

  /**
   * Determine whether the user can delete any models.
   */
  public function deleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('delete-any User');
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('restore User');
  }

  /**
   * Determine whether the user can restore any models.
   */
  public function restoreAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('restore-any User');
  }

  /**
   * Determine whether the user can replicate the model.
   */
  public function replicate(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('replicate User');
  }

  /**
   * Determine whether the user can reorder the models.
   */
  public function reorder(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('reorder User');
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, User $model): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('force-delete User');
  }

  /**
   * Determine whether the user can permanently delete any models.
   */
  public function forceDeleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('force-delete-any User');
  }
}