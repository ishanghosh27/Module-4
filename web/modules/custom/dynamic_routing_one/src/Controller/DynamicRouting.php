<?php

namespace Drupal\dynamic_routing_one\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This class displays greeting message based on the parameters provided in URL.
 */
class DynamicRouting extends ControllerBase {

  /**
   * Displays greeting message based on the parameters provided in URL.
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
      '#markup' => 'Welcome to this Dynamic Routing Page designed by ' . $para_1 . ' and ' . $para_2 . ' !',
    ];
  }

  /**
   * Displays task two message based on the parameter provided in URL.
   *
   * @param int $data
   *   Stores the URL parameter.
   *
   * @return array
   *   Returns the greeting message with the parameter fetched from the URL.
   */
  public function campaign(int $data) {
    return [
      '#title' => 'Task Two - Parameter ' . $data,
      '#type' => 'markup',
      '#markup' => 'Welcome to the task ' . $data . ' menu!',
    ];
  }

}
