<?php

namespace Drupal\loremipsum\Controller;

/**
 * Controller for Lorem ipsum page.
 */
class LoremIpsumController {

  /**
   * Displays the title of this page.
   *
   *   @return array
   */
  public function generate() {
    return [
      '#title' => 'HELLO'
    ];
  }

}
