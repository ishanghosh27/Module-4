<?php

namespace Drupal\custom_one\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class returns a basic page with a personalized greeting.
 */
class CustomOneController extends ControllerBase {

  /**
   * Stores the current logged in user account.
   *
   * @var object
   */
  protected $currentUser;

  /**
   * This method initializes the current logged in user.
   *
   *   @param AccountInterface $current_user
   *     Stores the object of the AccountInterface class - current logged in user.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('current_user'));
  }

  /**
   * This method returns a page with a personalized greeting if logged in. Else,
   * redirects user to the login page.
   *
   *   @return array
   *     The render array for the page.
   */
  public function customOne() {
    $username = $this->currentUser->getAccountName();
    return [
      '#title' => 'Custom One Page',
      '#markup' => '<h4>Hello, ' . $username . '</h4>',
    ];
  }

}

?>
