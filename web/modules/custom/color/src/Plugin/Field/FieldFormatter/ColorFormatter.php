<?php

namespace Drupal\color\Plugin\Field\FieldFormatter;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'ColorFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "color_formatter",
 *   label = @Translation("Background Color Formatter"),
 *   field_types = {
 *     "color"
 *   }
 * )
 */
class ColorFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      $data = Json::decode($value);
      if ($data && isset($data['type'])) {
        switch ($data['type']) {

          case 'rgb':
            $red = $data['red'];
            $green = $data['green'];
            $blue = $data['blue'];
            $background_color = "rgb($red, $green, $blue)";
            break;

          case 'color_wheel':
            $background_color = $data['color_picker'];
            break;

          case 'hex':
            $background_color = $data['hex_value'];
            break;

        }

        $elements[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#attributes' => [
            'style' => 'background-color:' . $background_color,
          ],
          '#value' => $background_color,
        ];
      }
    }
    return $elements;
  }

}
