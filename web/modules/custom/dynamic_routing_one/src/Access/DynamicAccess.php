<?php

namespace Drupal\dynamic_routing_one\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * This class defines the access restriction to the path.
 */
class DynamicAccess {

  /**
   * This method defines the access restriction to the path.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Stores the object of AccountInterface class.
   *
   * @return \Drupal\Core\Access\AccessResult
   *   Returns the forbidden access of content_editor role.
   */
  public function access(AccountInterface $account) {
    $role = $account->getRoles();
    if (in_array('content_editor', $role)) {
      return AccessResult::forbidden();
    }
    return AccessResult::allowedIf($account->hasPermission('access dynamic custom page'));
  }

}
