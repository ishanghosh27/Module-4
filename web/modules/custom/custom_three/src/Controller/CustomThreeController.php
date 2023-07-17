<?php

namespace Drupal\custom_three\Controller;

/**
 *
 */
class CustomThreeController {

  /**
   *
   */
  public function customThree() {
    return [
      '#title' => 'Custom Three Page',
      '#markup' => '<h4>Welcome To Custom Three Page. This Is The First Time We Are Using Custom Hooks</h4>',
    ];
  }

}
