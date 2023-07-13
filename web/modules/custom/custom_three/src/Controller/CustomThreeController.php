<?php

namespace Drupal\custom_three\Controller;

/**
 * This class displays the title and a markup of the page.
 */
class CustomThreeController {
  /**
   * This method displays the title and a markup of the page.
   *
   *   @return array
   *     Returns the title and a paragraph with a welcome message.
   */
  public function customThree() {
    return [
      '#title' => 'Custom Three Page',
      '#markup' => '<h4>Welcome To Custom Three Page. This Is The First Time We Are Using Custom Hooks</h4>',
    ];
  }

}

?>
