<?php

namespace Drupal\address\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface as StorageDefinition;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'address' field type.
 *
 * @FieldType(
 *   id = "Address",
 *   label = @Translation("Address"),
 *   description = @Translation("Stores an address."),
 *   category = @Translation("Custom"),
 *   default_widget = "AddressDefaultWidget",
 *   default_formatter = "AddressDefaultFormatter"
 * )
 */
class Address extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(StorageDefinition $storage) {
    $properties = [];
    $properties['street'] = DataDefinition::create('string')
      ->setLabel(t('Street'));
    $properties['city'] = DataDefinition::create('string')
      ->setLabel(t('City'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(StorageDefinition $storage) {
    $columns = [];
    $columns['street'] = [
      'type' => 'char',
      'length' => 255,
    ];
    $columns['city'] = [
      'type' => 'char',
      'length' => 255,
    ];
    return [
      'columns' => $columns,
      'indexes' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $isEmpty =
      empty($this->get('street')->getValue()) &&
      empty($this->get('city')->getValue());
    return $isEmpty;
  }

}
