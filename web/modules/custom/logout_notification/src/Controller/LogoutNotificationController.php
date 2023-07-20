<?php

namespace Drupal\logout_notification\Controller;

/**
 * This class shows the message when user logs out.
 */
class LogoutNotificationController {

  /**
   * This method displays the message when user logs out.
   *
   * @return mixed
   *   Returns a paragraph with the message.
   */
  public function notification() {
    return [
      '#markup' => '<h5>We are sad to see you leave :(</h5>',
    ];
  }

}
