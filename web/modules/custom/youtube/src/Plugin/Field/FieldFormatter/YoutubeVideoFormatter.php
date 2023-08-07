<?php

namespace Drupal\youtube\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'YoutubeVideoFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "YoutubeVideoFormatter",
 *   label = @Translation("Displays Youtube video"),
 *   field_types = {
 *     "youtube"
 *   }
 * )
 */
class YoutubeVideoFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'width' => '600',
      'height' => '450',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Youtube video width'),
      '#default_value' => $this->getSetting('width'),
    ];
    $elements['height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Youtube video height'),
      '#default_value' => $this->getSetting('height'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $width = $this->getSetting('width');
    $height = $this->getSetting('height');
    foreach ($items as $delta => $item) {
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $item->value, $matches);
      if (!empty($matches)) {
        $elements[$delta] = [
          '#theme' => 'youtube_video_formatter',
          '#width' => $width,
          '#height' => $height,
          '#video_id' => $matches[0],
        ];
      }
    }
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $settings = $this->getSettings();
    if (!empty($settings['width']) && !empty($settings['height'])) {
      $summary[] = $this->t('Video size: @width x @height', [
        '@width' => $settings['width'],
        '@height' => $settings['height'],
      ]);
    }
    else {
      $summary[] = $this->t('Define video size');
    }
    return $summary;
  }

}
