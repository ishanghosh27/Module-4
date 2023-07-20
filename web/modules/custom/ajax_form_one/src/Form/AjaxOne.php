<?php

namespace Drupal\ajax_form_one\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_validations\CustomValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a config form which uses AJAX to validate and submit data.
 */
class AjaxOne extends ConfigFormBase {

  /**
   * Initializes the \Drupal\Core\Ajax\AjaxResponse instance.
   *
   * @var \Drupal\Core\Ajax\AjaxResponse
   */
  protected $response;

  /**
   * Stores the validation object.
   *
   * @var object
   */
  protected $validation;

  /**
   * Initializes the validation of the form.
   *
   * Storing the AjaxResponse instance to the class variable.
   *
   * @param \Drupal\custom_validations\CustomValidator $validation
   *   Stores the object of the CustomValidator class.
   */
  public function __construct(CustomValidator $validation) {
    $this->validation = $validation;
    $this->response = new AjaxResponse();
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
    return 'ajax_form_one_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ajax_form_one.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['fullName'] = [
      '#type' => 'textfield',
      '#title' => 'Full Name',
      '#suffix' => '<div id="full-name-error"><strong></strong></div>',
      '#attributes' => [
        'placeholder' => 'Enter Full Name',
      ],
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => 'Phone Number',
      '#suffix' => '<div id="phone-error"><strong></strong></div>',
      '#attributes' => [
        'placeholder' => 'Enter Phone Number',
      ],
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email ID',
      '#suffix' => '<div id="email-error"><strong></strong></div>',
      '#attributes' => [
        'placeholder' => 'Enter Email ID',
      ],
    ];
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => 'Gender',
      '#suffix' => '<div id="gender-error"><strong></strong></div>',
      '#attributes' => [
        'placeholder' => 'Select Gender',
      ],
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
        'Other' => $this->t('Other'),
      ],
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
      '#suffix' => '<div id="submit-success"><strong></strong></div>',
      '#ajax' => [
        'callback' => '::validateAjaxForm',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Validating Form'),
        ],
      ],
    ];
    return $form;
  }

  /**
   * This method calls all the individual validation functions.
   *
   * If there are no errors, calls the function which submits data.
   *
   * @param array $form
   *   Stores the data in the form fields.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of FormStateInterface.
   *
   * @return object
   *   Calls the individual validation functions and returns the errors, if
   *   any, else calls the function which submits the input data and saves the
   *   configuration.
   */
  public function validateAjaxForm(array &$form, FormStateInterface $form_state) {
    $errorsName = $this->validation->validateName($form, $form_state);
    $errorsPhone = $this->validation->validatePhone($form, $form_state);
    $errorsEmail = $this->validation->validateEmail($form, $form_state);
    $errorsGender = $this->validation->validateGender($form, $form_state);
    $this->response->addCommand(new HtmlCommand('#full-name-error strong', ''));
    $this->response->addCommand(new HtmlCommand('#phone-error strong', ''));
    $this->response->addCommand(new HtmlCommand('#email-error strong', ''));
    $this->response->addCommand(new HtmlCommand('#gender-error strong', ''));
    foreach ($errorsName as $field => $error) {
      $this->response->addCommand(new HtmlCommand('#' . $field . '-error strong', $error));
      $this->response->addCommand(new CssCommand('#' . $field . '-error', ['color' => '#DC3545']));
    }
    foreach ($errorsPhone as $field => $error) {
      $this->response->addCommand(new HtmlCommand('#' . $field . '-error strong', $error));
      $this->response->addCommand(new CssCommand('#' . $field . '-error', ['color' => '#DC3545']));
    }
    foreach ($errorsEmail as $field => $error) {
      $this->response->addCommand(new HtmlCommand('#' . $field . '-error strong', $error));
      $this->response->addCommand(new CssCommand('#' . $field . '-error', ['color' => '#DC3545']));
    }
    foreach ($errorsGender as $field => $error) {
      $this->response->addCommand(new HtmlCommand('#' . $field . '-error strong', $error));
      $this->response->addCommand(new CssCommand('#' . $field . '-error', ['color' => '#DC3545']));
    }
    if (!$form_state->hasAnyErrors()) {
      $this->submitAjaxForm($form, $form_state);
    }
    return $this->response;
  }

  /**
   * This method submits the input data and saves the configuration file.
   *
   * @param array $form
   *   Stores the data in the form fields.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of FormStateInterface.
   */
  public function submitAjaxForm(array &$form, FormStateInterface $form_state) {
    $this->config('ajax_form_one.admin_settings')
      ->set('fullName', $form_state->getValue('fullName'))
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
