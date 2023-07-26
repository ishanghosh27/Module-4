<?php

namespace Drupal\youtube\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'Youtube' field type.
 *
 * @FieldType(
 *   id = "youtube",
 *   label = @Translation("Embed Youtube Video"),
 *   description = @Translation("Output video from Youtube."),
 *   category = @Translation("Custom"),
 *   default_widget = "YoutubeWidget",
 *   default_formatter = "YoutubeThumbnailFormatter"
 * )
 */
class Youtube extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Youtube video URL'));
    return $properties;
  }

}
