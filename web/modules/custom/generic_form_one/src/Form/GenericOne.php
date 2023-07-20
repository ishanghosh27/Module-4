<?php

namespace Drupal\generic_form_one\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\custom_validations\CustomValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class creates, validates, and displays a generic form.
 */
class GenericOne extends FormBase {

  /**
   * Stores the input data from the form.
   *
   * @var object
   */
  protected $message;

  /**
   * Stores the validation object.
   *
   * @var object
   */
  protected $validation;

  /**
   * Initializes the validation of the form & displays input data.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $message
   *   Stores the object of the MessengerInterface class.
   * @param \Drupal\custom_validations\CustomValidator $validation
   *   Stores the object of the CustomValidator class.
   */
  public function __construct(MessengerInterface $message, CustomValidator $validation) {
    $this->message = $message;
    $this->validation = $validation;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('messenger'), ($container->get('custom_validations.validator')));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'generic_form_one';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['fullName'] = [
      '#type' => 'textfield',
      '#title' => 'Enter Full Name',
      '#required' => TRUE,
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => 'Enter Phone Number',
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Enter Email ID',
      '#required' => TRUE,
    ];
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => 'Select Gender',
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
        'Other' => $this->t('Other'),
      ],
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $errorsName = $this->validation->validateName($form, $form_state);
    $errorsPhone = $this->validation->validatePhone($form, $form_state);
    $errorsEmail = $this->validation->validateEmail($form, $form_state);
    $errorsGender = $this->validation->validateGender($form, $form_state);
    foreach ($errorsName as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
    foreach ($errorsPhone as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
    foreach ($errorsEmail as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
    foreach ($errorsGender as $field => $error) {
      $form_state->setErrorByName($field, $error);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->message->addMessage("Generic Form One Submitted. The Entered Values Are As Follows -");
    foreach ($form_state->getValues() as $key => $value) {
      $this->message->addMessage($key . ': ' . $value);
    }
  }

}
