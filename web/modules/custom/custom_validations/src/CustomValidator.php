<?php

namespace Drupal\custom_validations;

use Drupal\Core\Form\FormStateInterface;

/**
 * This defines the custom validations for the custom config form.
 */
class CustomValidator {

  /**
   * Stores the errors array.
   *
   * @var array
   */
  protected $errors = [];

  /**
   * This method validates the Full Name.
   *
   * @param array $form
   *   Array of all the input data from the config form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of the FormStateInterface class.
   *
   * @return array
   *   Returns an array containing errors.
   */
  public function validateName(array &$form, FormStateInterface $form_state) {
    $fullName = $form_state->getValue('fullName');
    if (empty($fullName)) {
      $this->errors['full-name'] = 'Full Name Cannot Be Empty';
    }
    elseif (!preg_match('/^[a-zA-Z]/', $fullName)) {
      $this->errors['full-name'] = 'Full Name Can Only Contain Alphabets';
    }
    return $this->errors;
  }

  /**
   * This method validates the Phone number.
   *
   * @param array $form
   *   Array of all the input data from the config form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of the FormStateInterface class.
   *
   * @return array
   *   Returns an array containing errors.
   */
  public function validatePhone(array &$form, FormStateInterface $form_state) {
    $phone = $form_state->getValue('phone');
    if (empty($phone)) {
      $this->errors['phone'] = 'Phone Number Cannot Be Empty';
    }
    elseif (!preg_match('/^[6-9]\d{9}$/', $phone)) {
      $this->errors['phone'] = 'Please Enter A Valid Indian Phone Number';
    }
    return $this->errors;
  }

  /**
   * This method validates the Email.
   *
   * @param array $form
   *   Array of all the input data from the config form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of the FormStateInterface class.
   *
   * @return array
   *   Returns an array containing errors.
   */
  public function validateEmail(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    if (empty($email)) {
      $this->errors['email'] = 'Email ID Cannot Be Empty';
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = 'Invalid Email ID Syntax';
    }
    elseif (!in_array(
      substr($email, strrpos($email, '@') + 1),
      [
        'yahoo.com',
        'gmail.com',
        'outlook.com',
        'innoraft.com',
      ]
    )) {
      $this->errors['email'] = 'Only Public Domains (yahoo.com, gmail.com, outlook.com, innoraft.com) Are Allowed';
    }
    return $this->errors;
  }

  /**
   * This method validates the Gender.
   *
   * @param array $form
   *   Array of all the input data from the config form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of the FormStateInterface class.
   *
   * @return array
   *   Returns an array containing errors.
   */
  public function validateGender(array &$form, FormStateInterface $form_state) {
    $gender = $form_state->getValue('gender');
    if (empty($gender)) {
      $this->errors['gender'] = 'Gender Cannot Be Empty';
    }
    return $this->errors;
  }

}
