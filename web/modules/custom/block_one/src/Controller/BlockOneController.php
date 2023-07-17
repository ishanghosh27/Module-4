<?php

namespace Drupal\block_one\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This class returns a basic page with a personalized greeting.
 */
class BlockOneController extends ControllerBase {

  /**
   * This method creates an empty page.
   *
   * @return array
   *   The render array for the page.
   */
  public function blockOne() {
    return [];
  }

}
