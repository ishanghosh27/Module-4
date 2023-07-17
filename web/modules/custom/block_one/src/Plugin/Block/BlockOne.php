<?php

namespace Drupal\block_one\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "block_one",
 *   admin_label = @Translation("Block One"),
 *   category = "custom"
 * )
 */
class BlockOne extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    $routeMatch = \Drupal::routeMatch();
    if ($routeMatch->getRouteName() == 'custom-welcome-page') {
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
    return [
      '#theme' => 'block_one',
      '#attached' => [
        'library' => [
          'block_one/block-one',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition);
  }

}
