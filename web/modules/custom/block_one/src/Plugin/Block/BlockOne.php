<?php

namespace Drupal\block_one\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
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
   * Stores the current logged in user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface object
   */
  protected AccountProxyInterface $currentUser;

  /**
   * Stores the current route.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch object
   */
  protected CurrentRouteMatch $currentRoute;

  /**
   * This method initializes the current logged in user and the current route.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   Stores the object of the AccountProxyInterface class - current user.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $route_match
   *   Stores the object of the RouteMatch class - current route.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected AccountProxyInterface $current_user,
    protected CurrentRouteMatch $route_match
    ) {
    $this->currentUser = $current_user;
    $this->currentRoute = $route_match;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('current_route_match'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    $routeMatch = $this->currentRoute->getRouteName();
    if ($routeMatch === 'block_one.blockOne') {
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
    $user_name = $this->currentUser->getDisplayName();
    $user_role = $this->currentUser->getRoles();
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
