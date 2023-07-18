<?php

namespace Drupal\block_one\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "block_one",
 *   admin_label = @Translation("Block One"),
 *   category = "custom"
 * )
 */
class BlockOne extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    $routeMatch = \Drupal::routeMatch();
    if ($routeMatch->getRouteName() === 'block_one.blockOne') {
      return AccessResult::allowed();
    }
    else {
      return AccessResult::forbidden();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_user = \Drupal::currentUser();
    $user_name = $current_user->getDisplayName();
    $user_role = $current_user->getRoles();
    $main_roles = array_diff($user_role, ['authenticated']);
    return [
      '#theme' => 'block_one',
      '#username' => $user_name,
      '#userrole' => implode(', ', $main_roles),
      '#attached' => [
        'library' => [
          'block_one/block-one',
        ],
      ],
    ];
  }

}
