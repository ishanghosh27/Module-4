<?php

namespace Drupal\loremipsum\Controller;

/**
 * Controller for Lorem ipsum page.
 */
class LoremIpsumController {

  /**
   * Displays the title of this page.
   *
   * @return array
   *   Returns title of the page.
   */
  public function generate() {
    return [
      '#title' => 'HELLO',
    ];
  }

}
