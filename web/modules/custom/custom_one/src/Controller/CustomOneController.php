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
   *   @var object
   *     Stores the current logged in user account.
   */
  protected $currentUser;

  /**
   * This method initializes the current logged in user.
   *
   *   @param AccountInterface $current_user
   *     Stores the object of the AccountInterface class - current logged in user.
   *
   *   @return void
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * This static method gets the current logged in user.
   *
   *   @param ContainerInterface $container
   *     Stores the object of ContainerInterface class.
   *
   *   @return mixed
   *     Returns the current logged in user.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * This method returns a page with a personalized greeting.
   *
   *   @return mixed
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
