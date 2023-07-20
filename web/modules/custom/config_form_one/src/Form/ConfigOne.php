<?php

namespace Drupal\config_form_one\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_validations\CustomValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a config form with its build, validation and submission methods.
 */
class ConfigOne extends ConfigFormBase {

  /**
   * Stores the validation object.
   *
   * @var object
   */
  protected $validation;

  /**
   * This method initializes the validation of the form.
   *
   * @param \Drupal\custom_validations\CustomValidator $validation
   *   Stores the object of the CustomValidator class.
   */
  public function __construct(CustomValidator $validation) {
    $this->validation = $validation;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('custom_validations.validator'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form_one_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'config_form_one.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config_form_one.admin_settings');
    $form['fullName'] = [
      '#type' => 'textfield',
      '#title' => 'Enter Full Name',
      '#default_value' => $config->get('fullName'),
      '#required' => TRUE,
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => 'Enter Phone Number',
      '#default_value' => $config->get('phone'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Enter Email ID',
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => 'Select Gender',
      '#default_value' => $config->get('gender'),
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
        'Other' => $this->t('Other'),
      ],
      '#required' => TRUE,
    ];
    $form['quantity_range'] = [
      '#type' => 'range',
      '#title' => 'How Much Do You Like This Module?',
      '#default_value' => $config->get('quality_range'),
    ];
    $form['message'] = [
      '#type' => 'textfield',
      '#title' => 'Your message',
      '#default_value' => $config->get('message'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $errorsName = $this->validation->validateName($form, $form_state);
    $errorsPhone = $this->validation->validatePhone($form, $form_state);
    $errorsEmail = $this->validation->validateEmail($form, $form_state);
    foreach ($errorsName as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
    foreach ($errorsPhone as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
    foreach ($errorsEmail as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(&$form, FormStateInterface $form_state) {
    $this->config('config_form_one.admin_settings')
      ->set('fullName', $form_state->getValue('fullName'))
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->set('quantity_range', $form_state->getValue('quantity_range'))
      ->set('message', $form_state->getValue('message'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
