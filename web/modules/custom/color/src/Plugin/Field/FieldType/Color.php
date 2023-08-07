<?php

namespace Drupal\color\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'Color' field type.
 *
 * @FieldType(
 *   id = "color",
 *   label = @Translation("Color"),
 *   description = @Translation("Stores a color."),
 *   category = @Translation("Custom"),
 *   default_widget = "hex_widget",
 *   default_formatter = "color_formatter"
 * )
 */
class Color extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $storage) {
    $properties = [];
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Color Value'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $storage) {
    return [
      'columns' => [
        'value' => [
          'type' => 'text',
          'size' => 'big',
          'serialize' => TRUE,
        ],
      ],
      'indexes' => [],
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
  public function viewField(FieldItemListInterface $items, $display_options = []) {

  }

}
