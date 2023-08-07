<?php

namespace Drupal\color\Plugin\Field\FieldWidget;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ColorWheelWidget' widget.
 *
 * @FieldWidget(
 *   id = "color_wheel_widget",
 *   label = @Translation("Color Wheel Widget"),
 *   field_types = {
 *     "color"
 *   }
 * )
 */
class ColorWheelWidget extends WidgetBase {

  /**
   * Stores the current logged in user account.
   *
   * @var object
   */
  protected $currentUser;

  /**
   * The field definition.
   *
   * @var \Drupal\Core\Field\FieldDefinitionInterface
   */
  protected $fieldDefinition;

  /**
   * The widget settings.
   *
   * @var array
   */
  protected $settings;

  /**
   * Constructs a WidgetBase object.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   Stores the object of the AccountInterface class - current logged in user.
   * @param string $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   */
  public function __construct(AccountInterface $current_user, $plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->fieldDefinition = $field_definition;
    $this->settings = $settings;
    $this->thirdPartySettings = $third_party_settings;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($container->get('current_user'), $plugin_id, $plugin_definition, $configuration['field_definition'], $configuration['settings'], $configuration['third_party_settings']);
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state
    ) {
    $element['value'] = [
      '#type' => 'color',
      '#title' => $this->t('C
      olor Wheel'),
      '#description' => $this->t('Choose A Color'),
      '#default_value' => isset($items[$delta]->value) ?? $items[$delta]->value ?? '',
      '#access' => $this->currentUser->hasPermission('color field access'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value['value'] = Json::encode([
        'type' => 'color_wheel',
        'color_picker' => $value['value'],
      ]);
    }
    return $values;
  }

}
