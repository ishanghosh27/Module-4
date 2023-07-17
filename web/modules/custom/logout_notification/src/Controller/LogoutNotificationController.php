<?php

namespace Drupal\logout_notification\Controller;

/**
 * This class displays the notification after user logs out.
 */
class LogoutNotificationController {

  /**
   * This method returns the message when user logs out.
   *
   * @return array
   *   Returns the message when user logs out.
   */
  public function notification() {
    return [
      '#markup' => '<h5>We are sad to see you leave :(</h5>',
    ];
  }

}
