<?php
/**
 * @file
 * Contains \Drupal\generic_form_one\Form\GenericOne.
 */
  namespace Drupal\generic_form_one\Form;

  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * This class creates, validates, and displays a generic form.
   */
  class GenericOne extends FormBase {

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
      // Full Name Field
      $form['fullName'] = [
        '#type' => 'textfield',
        '#title' => t('Enter Full Name'),
        '#required' => TRUE,
      ];
      // Phone Number Field
      $form['phone'] = [
        '#type' => 'tel',
        '#title' => t('Enter Phone Number'),
        '#required' => TRUE,
      ];
      // Email ID Field
      $form['email'] = [
        '#type' => 'email',
        '#title' => t('Enter Email ID'),
        '#required' => TRUE,
      ];
      // Gender Field
      $form['gender'] = [
        '#type' => 'radios',
        '#title' => t('Select Gender'),
        '#options' => [
          'Male' => t('Male'),
          'Female' => t('Female'),
          'Other' => t('Other'),
        ],
        '#required' => TRUE,
      ];
      // Submit Button
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
      // Validate Phone Number
      // If the phone number is empty, display error message
      if (empty($form_state->getValue('phone'))) {
        $form_state->setErrorByName('phone', $this->t('Phone Number Cannot Be Empty'));
      }
      // If the phone number doesn't match regex pattern, display error message
      elseif (!preg_match('/^[6-9]\d{9}$/', ($form_state->getValue('phone')))) {
        $form_state->setErrorByName('phone', $this->t('Please Enter A Valid Indian Phone Number'));
      }
      // Validate Email ID
      $email = $form_state->getValue('email');
      // If Email ID is empty, display error message
      if (empty($email)) {
        $form_state->setErrorByName('email', $this->t('Email ID Cannot Be Empty'));
      }
      // If Email ID doesn't match criteria, display error message
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_state->setErrorByName('email', $this->t('Invalid Email ID Syntax'));
      }
      // If Email ID doesn't match criteria, display error message
      elseif (!in_array(substr($email, strrpos($email, '@') + 1), ['yahoo.com', 'gmail.com', 'outlook.com'])) {
        $form_state->setErrorByName('email', $this->t('Only Public Domains (yahoo.com,gmail.com,outlook.com) Are Allowed'));
      }
      // If Email ID doesn't match criteria, display error message
      elseif (!preg_match('/\.com$/', $email)) {
        $form_state->setErrorByName('email', $this->t('Email ID Should End With ".com"'));
      }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      \Drupal::messenger()->addMessage(t("Generic Form One Submitted. The Entered Values Are As Follows -"));
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . $value);
      }
    }

  }

?>
