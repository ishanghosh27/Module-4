<?php

namespace Drupal\dynamic_routing_one\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This class displays a greeting message based on the parameters provided in
 * the URL.
 */
class DynamicRouting extends ControllerBase {

  /**
   * This method displays a greeting message based on the parameters provided
   * in the URL.
   *
   * @param string $para_1
   *   Stores the first parameter.
   * @param string $para_2
   *   Stores the second parameter.
   *
   * @return array
   *   Returns the greeting message with the parameters fetched from the URL.
   */
  public function content(string $para_1, string $para_2) {
    return [
      '#type' => 'markup',
      '#markup' => t(string: 'Welcome to this Dynamic Routing Page designed by ' .$para_1. ' and ' .$para_2. ' !'),
    ];
  }

}

?>
