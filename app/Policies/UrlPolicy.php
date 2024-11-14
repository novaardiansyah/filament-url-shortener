<?php

namespace App\Policies;

use App\Models\Url;
use App\Models\User;

class UrlPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view-any Url');
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('view Url');
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('create Url');
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || ($user->checkPermissionTo('update Url') && $user->id == $url->user_id);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || ($user->checkPermissionTo('delete Url') && $user->id == $url->user_id);
  }

  /**
   * Determine whether the user can delete any models.
   */
  public function deleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('delete-any Url');
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || ($user->checkPermissionTo('restore Url') && $user->id == $url->user_id);
  }

  /**
   * Determine whether the user can restore any models.
   */
  public function restoreAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('restore-any Url');
  }

  /**
   * Determine whether the user can replicate the model.
   */
  public function replicate(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || ($user->checkPermissionTo('replicate Url') && $user->id == $url->user_id);
  }

  /**
   * Determine whether the user can reorder the models.
   */
  public function reorder(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('reorder Url');
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Url $url): bool
  {
    return $user->checkPermissionTo('*') || ($user->checkPermissionTo('force-delete Url') && $user->id == $url->user_id);
  }

  /**
   * Determine whether the user can permanently delete any models.
   */
  public function forceDeleteAny(User $user): bool
  {
    return $user->checkPermissionTo('*') || $user->checkPermissionTo('force-delete-any Url');
  }
}
