<?php

namespace Drupal\address\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'AddressDefaultWidget' widget.
 *
 * @FieldWidget(
 *   id = "AddressDefaultWidget",
 *   label = @Translation("Address select"),
 *   field_types = {
 *     "Address"
 *   }
 * )
 */
class AddressDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    Array $element,
    Array &$form,
    FormStateInterface $formState
  ) {
    $element['street'] = [
      '#type' => 'textfield',
      '#title' => 'Street',
      '#default_value' => $items[$delta]->street ?? NULL,
      '#empty_value' => '',
      '#placeholder' => 'Street',
    ];
    $element['city'] = [
      '#type' => 'textfield',
      '#title' => 'City',
      '#default_value' => $items[$delta]->city ?? NULL,
      '#empty_value' => '',
      '#placeholder' => 'City',
    ];
    return $element;
  }

}
