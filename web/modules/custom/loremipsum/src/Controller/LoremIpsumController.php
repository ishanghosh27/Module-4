<?php

namespace Drupal\loremipsum\Controller;

/**
 * Controller routines for Lorem ipsum pages.
 */
class LoremIpsumController {

  /**
   * Constructs Lorem ipsum text with arguments.
   * This callback is mapped to the path
   * 'loremipsum/generate/{paragraphs}/{phrases}'.
   *
   * @param string $paragraphs
   *   The amount of paragraphs that need to be generated.
   * @param string $phrases
   *   The maximum amount of phrases that can be generated inside a paragraph.
   */
  public function generate() {

    return [
      '#title' => 'HELLO'
    ];
  }

}
