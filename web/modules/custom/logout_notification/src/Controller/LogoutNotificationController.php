<?php

  namespace Drupal\logout_notification\Controller;

  class LogoutNotificationController {
    public function notification() {
      return [
        '#markup' => '<h5>We are sad to see you leave :(</h5>',
      ];
    }

  }
?>
