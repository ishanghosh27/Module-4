<?php

namespace Drupal\movie_type\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with the budget judgement based of the config form.
 *
 * @Block(
 *   id = "budget",
 *   admin_label = @Translation("Budget Judgement"),
 *   category = "custom"
 * )
 */
class MovieBudgetJudgement extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The configuration factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

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
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Stores the object of the ConfigFactoryInterface class - config form.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected AccountProxyInterface $current_user,
    protected CurrentRouteMatch $route_match,
    protected ConfigFactoryInterface $config_factory
    ) {
    $this->currentUser = $current_user;
    $this->currentRoute = $route_match;
    $this->configFactory = $config_factory;
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
      $container->get('config.factory'),
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
    $node = $this->currentRoute->getParameter('node');
    if ($node instanceof NodeInterface && $node->getType() === 'movie_type') {
      if ($node->hasField('field_movie_price') && !$node->get('field_movie_price')->isEmpty()) {
        $config = $this->configFactory->get('movie_budget.admin_settings');
        $budget = $config->get('budget');
        if (!empty($budget)) {
          return AccessResult::allowed();
        }
        else {
          return AccessResult::forbidden();
        }
      }
      else {
        return AccessResult::forbidden();
      }
    }
    else {
      return AccessResult::forbidden();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('movie_budget.admin_settings');
    $budget = $config->get('budget');
    $node = $this->currentRoute->getParameter('node');
    $price = $node->get('field_movie_price')->value;
    if ($price > $budget) {
      $message = 'The movie is over budget!';
    }
    else {
      if ($price < $budget) {
        $message = 'The movie is under budget!';
      }
      else {
        if ($price = $budget) {
          $message = 'The movie is within budget!';
        }
      }
    }
    return [
      '#theme' => 'movie_budget',
      '#budget' => $message,
      '#attached' => [
        'library' => [
          'movie_type/movie-budget',
        ],
      ],
      '#cache' => [
        'tags' => [
          'node_list',
        ],
      ],
    ];
  }

}
