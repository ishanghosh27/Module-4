<?php

namespace Drupal\youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'YoutubeThumbnailFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "YoutubeThumbnailFormatter",
 *   label = @Translation("Displays Video Thumbnail"),
 *   field_types = {
 *     "youtube"
 *   }
 * )
 */
class YoutubeThumbnailFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $item->value, $matches);
      if (!empty($matches)) {
        $content = '<a href="' . $item->value . '" target="_blank"><img src="http://img.youtube.com/vi/' . $matches[0] . '/0.jpg"></a>';
        $elements[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => $content,
        ];
      }
    }
    return $elements;
  }

}
