<?php

namespace Drupal\address\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'AddressDefaultFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "AddressDefaultFormatter",
 *   label = @Translation("Address"),
 *   field_types = {
 *     "Address"
 *   }
 * )
 */
class AddressDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => '<h5>' . $item->city . ' & ' . $item->street . '</h5>',
      ];
    }
    return $elements;
  }

}
